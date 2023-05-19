# E-commerce Website with Laravel

This repository contains the source code for an e-commerce website built using the Laravel framework. The website provides administrators with tools to manage categories and products, while allowing users to browse products, add them to the cart, and proceed to checkout.

## Features

- **Category Management**: Administrators can efficiently organize products into different categories for easy navigation and content organization.
- **Product Management**: Create, edit, and manage product details, such as title, description, price, and images, with a user-friendly interface.
- **User Browsing**: Users can browse through various categories and explore the available products, filtering them based on criteria like price range or popularity.
- **Cart Functionality**: Users can add products to their cart, review the selected items, and easily manage quantities before proceeding to checkout.
- **Session-Based Cart**: The cart functionality is implemented using sessions, allowing users to maintain their selected items throughout their browsing session.
- **Secure Checkout**: Users can securely proceed to the checkout process, enter shipping and payment details, and place their orders.
- **Order Management**: Administrators have access to an order management system to track and process customer orders.

## Getting Started

To set up the project locally, follow these steps:

1. Clone the repository: `git clone https://github.com/RatebBarakat/ecommerce.git`
2. Install dependencies: `composer install`
3. Configure the database in the `.env` file.
4. Run database migrations: `php artisan migrate`
5. Serve the application: `php artisan serve`

For more detailed instructions, refer to the [Installation Guide](docs/INSTALLATION.md).

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please feel free to submit a pull request or open an issue.

## License

This project is licensed under the [MIT License](LICENSE).

