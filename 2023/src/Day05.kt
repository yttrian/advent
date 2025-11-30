private fun part1(input: List<String>): Int = input.size

private fun part2(input: List<String>): Int = input.size

fun main() {
    // test if implementation meets criteria from the description, like:
    val testInput = readInput("Day05_test")
    check(part1(testInput) == 35)

    val input = readInput("Day05")
    part1(input).println()
    part2(input).println()
}
