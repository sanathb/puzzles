A company sells hundreds of products on-line and customer place orders from all over the world, just like eBay. Each product has a different weight and price.

Every customer can order any number of different products that need to be separated into one or more packages (each containing one or more products) and then collected by the courier company for delivery to the customer.

However, there are certain rules for each package that must be followed:
1. The total cost of all products within a single package cannot exceed $250 for international customs purposes.
2. If multiple packages for the same order are required, then the weight of each package should have the lowest possible shipping cost for the order and be as evenly distributed as possible.


Create a PHP page which has the following:
1. A simple vertical list of products (in the format Name - price - weight), with a check box next to items
2. A button saying "Place order"
3. When the user clicks on "Place order", the selected items should be submitted to the same page and the above rules should be applied to potentially divide this order into multiple packages
4. Display the output result on the same page. Below is a sample output on how it should look like:

This order has following packages:
Package 1
Items - Item 1, Item 3, item 7
Total weight - 510g
Total price - $240
Courier price - $15

Package 2
Items - Item 4, Item 6, item 2
Total weight - 530g
Total price - $160
Courier price - $15

Note: Items and courier prices are listed at the bottom of this document

We will be evaluating:
1. your code quality specifically comments (where required),
2. formatting,
3. naming conventions,
4. size of functions,
5. easy to read and understand,
6. simplicity,
7. other best practices, optimisation, etc.

Products:

Name Price($) Weight(g)
Item 1 10 200
Item 2 100 20
Item 3 30 300
Item 4 20 500
Item 5 30 250
Item 6 40 10
Item 7 200 10
Item 8 120 500
Item 9 130 790
Item 10 20 100
Item 11 10 340
Item 12 4 800
Item 13 5 200
Item 14 240 20
Item 15 123 700
Item 16 245 10
Item 17 230 20
Item 18 110 200
Item 19 45 200
Item 20 67 20
Item 21 88 300
Item 22 10 500
Item 23 17 250
Item 24 19 10
Item 25 89 10
Item 26 45 500
Item 27 99 790
Item 28 125 100
Item 29 198 340
Item 30 220 800
Item 31 249 200
Item 32 230 20
Item 33 190 700
Item 34 45 10
Item 35 12 20
Item 36 5 200
Item 37 2 200
Item 38 90 20
Item 39 12 300
Item 40 167 500
Item 41 12 250
Item 42 8 10
Item 43 2 10
Item 44 9 500
Item 45 210 790
Item 46 167 100
Item 47 23 340
Item 48 190 800
Item 49 199 200
Item 50 12 20


Courier Charges

Weight(g) Charge($)
0 to 200g $5
201g to 500g $10
500g to 1000g $15
1001g to 5000g $20
