private sealed interface Item
private data class PartNumber(val number: Int, val x1: Int, val x2: Int, val y: Int) : Item
private data class Symbol(val symbol: Char, val x: Int, val y: Int) : Item

// Start or lengthen a part number
private fun PartNumber?.grow(digit: Char, x: Int, y: Int) =
    this?.copy(number = "$number$digit".toInt(), x2 = x) ?: PartNumber(number = "$digit".toInt(), x1 = x, x2 = x, y = y)

// Find all the items in the muck
private fun List<String>.findItems(): List<Item> = flatMapIndexed { y, line ->
    buildList {
        // Build items
        line.foldIndexed<PartNumber?>(null) { x, partNumber, char ->
            if (char.isDigit()) {
                partNumber.grow(char, x, y)
            } else {
                // Add the current part number to the list (if there is one)
                partNumber?.let { add(it) }

                // Add non-dot symbols to the list
                if (char != '.') {
                    add(Symbol(char, x, y))
                }

                // Restart looking
                null
            }
        }?.also { finalPartNumber ->
            // Make sure to add the final part number that was being built
            add(finalPartNumber)
        }
    }
}

// Check if part number is touching a symbol
private fun PartNumber.isTouching(symbol: Symbol): Boolean {
    val xRange = (x1 - 1)..(x2 + 1)
    val yRange = (y - 1)..(y + 1)

    return symbol.x in xRange && symbol.y in yRange
}

// Filter part numbers to those touching symbols
private fun List<Item>.filterValidPartNumbers(): List<PartNumber> {
    val symbols = filterIsInstance<Symbol>()

    return filterIsInstance<PartNumber>().filter { partNumber ->
        symbols.any { partNumber.isTouching(it) }
    }
}

// Sum all the part numbers touching non-dot symbols
private fun part1(input: List<String>): Int = input.findItems().filterValidPartNumbers().sumOf { it.number }

// Calculate all gear ratios
private fun List<Item>.calculateGearRatios(): List<Int> {
    val gears = filterIsInstance<Symbol>().filter { it.symbol == '*' }
    val partNumbers = filterIsInstance<PartNumber>()

    return gears.map { gear ->
        // Find the part numbers touching a gear
        partNumbers.filter { it.isTouching(gear) }
    }.filter {
        // Exactly two part numbers can touch a true gear
        it.size == 2
    }.map { (a, b) ->
        // Multiply the part numbers together
        a.number * b.number
    }
}

// Sum all the gear ratios
private fun part2(input: List<String>): Int = input.findItems().calculateGearRatios().sum()

fun main() {
    // test if implementation meets criteria from the description, like:
    val testInput = readInput("Day03_test")
    check(part1(testInput) == 4361)
    check(part2(testInput) == 467835)

    val input = readInput("Day03")
    part1(input).println()
    part2(input).println()
}
