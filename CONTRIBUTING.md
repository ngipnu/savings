# Contributing to TASIA

Thank you for considering contributing to TASIA! This document provides guidelines for contributing to the project.

## Code of Conduct

This project adheres to a code of conduct. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce**
- **Expected behavior**
- **Actual behavior**
- **Screenshots** (if applicable)
- **Environment details** (OS, PHP version, Laravel version)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Clear title and description**
- **Use case** - Why would this be useful?
- **Possible implementation** - If you have ideas on how to implement it

### Pull Requests

1. Fork the repository
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Make your changes
4. Follow the coding standards (PSR-12)
5. Write or update tests as needed
6. Update documentation if needed
7. Commit your changes: `git commit -m 'Add some feature'`
8. Push to your fork: `git push origin feature/your-feature-name`
9. Submit a pull request

## Development Setup

### Prerequisites

- PHP >= 8.5
- Composer
- Node.js & NPM
- SQLite/MySQL

### Setup Steps

```bash
# Clone repository
git clone https://github.com/yourusername/tasia.git
cd tasia

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# Build assets
npm run dev

# Run tests
php artisan test

# Start development server
php artisan serve
```

## Coding Standards

### PHP

- Follow PSR-12 coding standard
- Use type hints wherever possible
- Write descriptive variable and function names
- Add PHPDoc blocks for classes and methods

### JavaScript

- Use ES6+ syntax
- Follow Alpine.js best practices
- Keep components small and focused

### Blade Templates

- Use proper indentation
- Keep logic minimal in views
- Use components for reusable UI elements

### CSS/Tailwind

- Use Tailwind utility classes
- Avoid custom CSS when possible
- Keep color scheme consistent

## Testing

- Write tests for new features
- Ensure existing tests pass
- Aim for high code coverage

```bash
php artisan test
php artisan test --coverage
```

## Git Commit Messages

- Use present tense ("Add feature" not "Added feature")
- Use imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit first line to 72 characters
- Reference issues and pull requests

Examples:

```
feat: Add notification dropdown for admin dashboard
fix: Resolve transaction approval bug
docs: Update installation instructions
style: Format code according to PSR-12
refactor: Simplify transaction query logic
test: Add tests for student dashboard
```

## Documentation

- Update README.md if needed
- Add inline comments for complex logic
- Update API documentation (when available)
- Keep CHANGELOG.md updated

## Questions?

Feel free to open an issue or contact the maintainers.

Thank you for contributing! 🎉
