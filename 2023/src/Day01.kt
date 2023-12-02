import arrow.core.fold

private fun rip(line: String) = "${line.first(Char::isDigit)}${line.last(Char::isDigit)}".toInt()

private fun part1(input: List<String>): Int = input.map(::rip).sum()

val fixes = mapOf(
    "one" to 1,
    "two" to 2,
    "three" to 3,
    "four" to 4,
    "five" to 5,
    "six" to 6,
    "seven" to 7,
    "eight" to 8,
    "nine" to 9,
).mapValues { (key, value) -> "$key$value$key" }

private fun fix(line: String) = fixes.fold(line) { fixed, (bad, good) -> fixed.replace(bad, good) }

private fun part2(input: List<String>): Int = part1(input.map(::fix))

fun main() {
    // test if implementation meets criteria from the description, like:
    val testInput = readInput("Day01_test")
    check(part1(testInput) == 142)

    val input = readInput("Day01")
    part1(input).println()
    part2(input).println()
}
