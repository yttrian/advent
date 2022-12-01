import kotlin.test.Test

class Day1Test {
    @Test
    fun solve() {
        val lines = javaClass.getResource("day1.txt")?.readText()?.lines()
        println(Day1.solve(lines!!))
    }
}
