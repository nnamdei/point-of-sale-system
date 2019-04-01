## Sales Management System

This application is for managing goods or products. It can be used in supermarket or stores.

## What it can do

- Manage different kind of goods. When adding new product, you have the option to add it as a simple product or variable product. Variable products refers to poducts that has attribute (e.g color, size). Products can also be converted from simple to variable and vice versa
- Comprehensive insight of stocks. This application will give insight to products collectively and individually, you will be able to see the monetary value of your stocks, how much profit you have made and your prospective profit.
- Graphical representation. You can easily view your sales on a simple column chart (credit to [FusionChart](https://www.fusioncharts.com))
- Transaction Filter. You can view your transactions (including sales and stock updates) at dfferent times or within a range of period
- Different Levels of users. The application allow for two different levels of users - Manager and Attendant - with different priviledges. The manager will be able to add products, create categories, open/close attendants' desks, view products insight. The attendant can add product to cart and checkout.
- Multiple sale. The application uses [Laravel shopping cart](https://github.com/Crinsane/LaravelShoppingcart) to add multiple items to cart for one customer.
- Receipt printing. The application uses [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) to generate receipt that can be printed when a cart is checked out. The receipt is configured for Thermal printer of paper with width of 58mm.
- Receipt verification. Every cart used for sale by the attendant has unique reference and are saved and also inscribed on the customer's receipt.This can be used for verification of customer's receipt incase of any issue.
