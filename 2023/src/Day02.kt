import kotlin.math.max

private fun games(input: List<String>) = input.associate { line ->
    // Convert each line into its game number and story
    val (game, story) = line.split(":")
    game.removePrefix("Game ").toInt() to story
}.mapValues { (_, story) ->
    // Split the story of each game into its rounds
    story.split(";").flatMap { round ->
        // Split each round into the individual drawings
        round.split(",").map { draw ->
            // Convert the drawing to a pair
            val (count, color) = draw.trim().split(" ")
            color to count.toInt()
        }
    }.groupingBy { (color, _) ->
        // Group the drawings on their color
        color
    }.fold(0) { largest, (_, current) ->
        // Find the max number drawn for each color
        max(largest, current)
    }
}

// Rule given for part1
private val rule = mapOf("red" to 12, "green" to 13, "blue" to 14)

// Add game numbers that fit the rules
private fun part1(input: List<String>): Int = games(input).filterValues { maxes ->
    // Check each game is less than the rule using the evil double-bang to skip a useless null-check
    maxes.all { (color, count) -> rule[color]!! >= count }
}.keys.sum()

// Sum the power of the minimum cubes needed per color for each game
private fun part2(input: List<String>): Int = games(input).values.sumOf { maxes ->
    // Calculate the power of each set
    maxes.values.reduce { a, b -> a * b }
}

fun main() {
    // test if implementation meets criteria from the description, like:
    val testInput = readInput("Day02_test")
    check(part1(testInput) == 8)

    val input = readInput("Day02")
    part1(input).println()
    part2(input).println()
}
