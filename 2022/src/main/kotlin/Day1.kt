object Day1 : Puzzle {
    private const val TOP_ELVES = 3

    override fun solve(lines: List<String>): Pair<Int, Int> {
        val elves = lines.fold(listOf(0)) { accumulator, line ->
            val calories = line.toIntOrNull()

            if (calories != null) {
                accumulator.dropLast(1).plus(accumulator.last() + calories)
            } else {
                accumulator.plus(0)
            }
        }

        val max = elves.max()
        val topTotal = elves.sortedDescending().take(TOP_ELVES).sum()

        return max to topTotal
    }
}
