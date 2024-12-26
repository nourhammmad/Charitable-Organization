<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest - Home</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
}

header nav ul {
    list-style-type: none;
    text-align: center;
    margin: 0;
    padding: 0;
}

header nav ul li {
    display: inline;
    margin: 0 20px;
}

header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
}

h1, h2 {
    color: #333;
}

section {
    padding: 20px;
    margin: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

footer {
    background-color: #333;
    color: #fff;
    padding: 10px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

form input, form textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

form button:hover {
    background-color: #45a049;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us & Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="#contact-us">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- About Us Section -->
    <section id="about-us" class="about-us">
        <h1>About Us</h1>
        <p>Welcome to our website! We are a passionate team committed to providing excellent services and products to our valued customers. Our mission is to deliver quality and satisfaction in everything we do.</p>

        <h2>Our Story</h2>
        <p>Founded in 2010, we started with a small idea and a big dream. Over the years, we've grown into a trusted name in our industry. Through hard work and dedication, we've managed to build lasting relationships with customers and partners alike.</p>

        <h2>Our Values</h2>
        <ul>
            <li>Customer Satisfaction</li>
            <li>Innovation</li>
            <li>Integrity</li>
            <li>Excellence</li>
        </ul>

        <h2>Meet Our Team</h2>
        <p>Our team consists of passionate and skilled professionals who are dedicated to making a difference in our industry.</p>
    </section>

    <!-- Contact Us Section -->
    <section id="contact-us" class="contact-us">
        <h1>Contact Us</h1>
        <p>If you have any questions, suggestions, or feedback, feel free to reach out to us. We're here to help!</p>

        <h2>Get in Touch</h2>
        <p>Email: <a href="mailto:contact@company.com">contact@company.com</a></p>
        <p>Phone: <a href="tel:+1234567890">+123-456-7890</a></p>

        <h2>Our Address</h2>
        <p>1234 Business Rd, City, Country</p>

        <h2>Contact Form</h2>
        <form action="#" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </section>

    <!-- Button to navigate back to index.php -->
    <section class="navigate-home">
        <button onclick="window.location.href='index.php'">Back to Home</button>
    </section>
    <br></br>

    <footer>
        <p>&copy; 2024 Our Company. All rights reserved.</p>
    </footer>

</body>
</html>
