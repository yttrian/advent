import kotlin.math.pow

// A scratch card
private data class ScratchCard(val card: Int, val winningNumbers: Set<Int>, val scratchedNumbers: Set<Int>)

// Regex to find numbers
private val numbers = Regex("\\d+")

// Find all numbers in a string
private fun String.findAllNumbers(): Set<Int> = numbers.findAll(this).map { it.value.toInt() }.toSet()

// Convert a line to a scratch card
private fun String.makeScratchCard(): ScratchCard {
    val (card, winningNumbers, scratchedNumbers) = split(':', '|')

    return ScratchCard(
        card = numbers.find(card)!!.value.toInt(),
        winningNumbers = winningNumbers.findAllNumbers(),
        scratchedNumbers = scratchedNumbers.findAllNumbers()
    )
}

// Count the number of matching numbers
private fun ScratchCard.matches(): Int = scratchedNumbers.intersect(winningNumbers).size

// Score the card by doubling for each match
private fun ScratchCard.score(): Int = when (val matches = matches()) {
    0 -> 0
    else -> 2.0.pow(matches - 1).toInt()
}

// Sum all scores
private fun part1(input: List<String>): Int = input.map { it.makeScratchCard() }.sumOf { it.score() }

// Calculate how many scratch cards we end up with
private fun part2(input: List<String>): Int {
    val initialScratchCards = input.map { it.makeScratchCard() }

    // What cards does a card win?
    fun ScratchCard.wins(): List<ScratchCard> {
        // Don't make an off-by-one error that will keep you up too late
        val range = when (val matches = matches()) {
            0 -> IntRange.EMPTY
            else -> card.rangeUntil(card.plus(matches).coerceAtMost(initialScratchCards.size))
        }

        return initialScratchCards.slice(range)
    }

    // Add up all the cards won
    fun expand(scratchCards: List<ScratchCard>): Int = when {
        scratchCards.isEmpty() -> 0
        else -> scratchCards.sumOf { 1 + expand(it.wins()) }
    }

    return expand(initialScratchCards)
}

fun main() {
    // test if implementation meets criteria from the description, like:
    val testInput = readInput("Day04_test")
    check(part1(testInput) == 13)
    check(part2(testInput) == 30)

    val input = readInput("Day04")
    part1(input).println()
    part2(input).println()
}
