function applyFilters() {
    var minPrice = parseFloat(document.getElementById("minPrice").value);
    var maxPrice = parseFloat(document.getElementById("maxPrice").value);
    var rating = parseInt(document.getElementById("rating").value);
    var fastDelivery = document.getElementById("fastDelivery").checked;
    var condition = document.getElementById("condition").value;

    // Use AJAX or fetch to send filter criteria to the PHP backend

    // For demonstration purposes, assume filtered products are hardcoded here
    var filteredProducts = [
        { name: "Product A", price: 100, rating: 4, delivery: true, condition: "new" },
        { name: "Product B", price: 150, rating: 5, delivery: false, condition: "used" },
        // ... other filtered products
    ];

    displayProducts(filteredProducts);
}

function displayProducts(products) {
    var productListDiv = document.getElementById("productList");
    productListDiv.innerHTML = "";

    products.forEach(function(product) {
        var productDiv = document.createElement("div");
        productDiv.innerHTML = `
            <h3>${product.name}</h3>
            <p>Price: $${product.price}</p>
            <p>Rating: ${product.rating} Stars</p>
            <p>${product.delivery ? "Fast Delivery Available" : "Standard Delivery"}</p>
            <p>Condition: ${product.condition}</p>
        `;
        productListDiv.appendChild(productDiv);
    });
}
