-- Smart Food Planner & Health Manager Database Schema

CREATE DATABASE IF NOT EXISTS food_planner;
USE food_planner;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    height DECIMAL(5,2), -- in cm
    weight DECIMAL(5,2), -- in kg
    goal ENUM('lose_weight', 'maintain', 'gain_muscle') DEFAULT 'maintain',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Recipes table
CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    cooking_time INT, -- in minutes
    calories INT,
    protein DECIMAL(5,2),
    carbs DECIMAL(5,2),
    fat DECIMAL(5,2),
    image VARCHAR(255),
    instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ingredients table
CREATE TABLE IF NOT EXISTS ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    unit VARCHAR(20)
);

-- Recipe Ingredients link table
CREATE TABLE IF NOT EXISTS recipe_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    ingredient_id INT,
    quantity DECIMAL(10,2),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
);

-- Grocery Lists table
CREATE TABLE IF NOT EXISTS grocery_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_cost DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Grocery Items table
CREATE TABLE IF NOT EXISTS grocery_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    list_id INT,
    recipe_id INT,
    serving_size INT DEFAULT 1,
    calories INT,
    log_date DATE,
    is_bought BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (list_id) REFERENCES grocery_lists(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE SET NULL
);

-- Reviews table for local discovery
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    place_id VARCHAR(255), -- Google Place ID
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Daily Nutrition Intake Tracking
CREATE TABLE IF NOT EXISTS daily_intake (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipe_id INT NULL,
    food_name VARCHAR(255) NOT NULL,
    calories INT NOT NULL,
    protein DECIMAL(5,2),
    carbs DECIMAL(5,2),
    fat DECIMAL(5,2),
    log_date DATE DEFAULT (CURRENT_DATE),
    log_time TIME DEFAULT (CURRENT_TIME),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE SET NULL
);
