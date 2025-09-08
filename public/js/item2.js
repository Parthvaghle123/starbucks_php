document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = "http://localhost:8080/"; // CHANGE as per your server
  let products = []; // Will be populated from database

  const searchInput = document.getElementById("search");
  const searchButton = document.getElementById("searchButton");
  const messageBox = document.getElementById("messageBox");
  const rootElement = document.getElementById("root1");

  // Load products from database on page load
  loadProductsFromDatabase();

  // Function to load products from database
  function loadProductsFromDatabase() {
    messageBox.style.display = "block";
    messageBox.textContent = "Loading products...";
    
    fetch('/api/products/menu')
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          throw new Error(data.message || 'Failed to load products');
        }
        products = data;
        displayItems(products);
        messageBox.style.display = "none";
      })
      .catch(error => {
        console.error('Error loading products:', error);
        messageBox.textContent = "Error loading products. Using fallback data.";
        messageBox.style.display = "block";
        
        // Fallback to static data if API fails
        setTimeout(() => {
          loadFallbackProducts();
        }, 2000);
      });
  }

  // Fallback function with static products if API fails
  function loadFallbackProducts() {
    products = [
      {
        id: 0,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/105468.jpg",
        title: "Cold Drink",
        per: "Our signature rich in flavour espresso blended with delicate...",
        price: 299,
      },
      {
        id: 1,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/101729.png",
        title: "Smoked Chicken",
        per: "A hearty Smoked Chicken & Salami Sandwich with tender smoked...",
        price: 399,
      },
      {
        id: 2,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/100433.jpg",
        title: "Cold Coffee",
        per: "Captivating, cosy, coffee. Gift your loved ones this Starbucks Gift Card.",
        price: 278,
      },
      {
        id: 3,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/114059.jpg",
        title: "Kosha Mangsho Wrap",
        per: "A traditional mutton preparation packed in a parantha...",
        price: 367,
      },
      {
        id: 4,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/103515.jpg",
        title: "Double Frappuccino",
        per: "Rich mocha-flavored sauce meets up with chocolaty chips, mil...",
        price: 420,
      },
      {
        id: 5,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/100100_1.png",
        title: "Chicken Sandwich",
        per: "Marinated tandoori paneer filling, sliced cheese, and whole...",
        price: 283,
      },
      {
        id: 6,
        image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/115751_1.png",
        title: "Cookie Creme Latte",
        per: "Handcrafted espresso from the world's top 3% Arabica with st...",
        price: 430,
      },
    ];
    displayItems(products);
    messageBox.style.display = "none";
  }

  // 🔍 Search logic with 2-second delay (simulation)
  function searchProducts(event) {
    if (event) event.preventDefault();
    messageBox.style.display = "block"; // Show "Searching..." message
    rootElement.innerHTML = ""; // Clear old results
    setTimeout(() => {
      filterAndDisplayItems(); // Filter after delay
      messageBox.style.display = "none"; // Hide message
    }, 2000);
  }

  const filterAndDisplayItems = () => {
    const searchData = searchInput.value.toLowerCase();
    const filteredData = products.filter((item) =>
      item.title.toLowerCase().includes(searchData)
    );
    displayItems(filteredData);
  };

  // Search input clearing logic
  searchInput.addEventListener("input", () => {
    if (searchInput.value === "") {
      displayItems(products);
    }
  });

  // Search button click event
  searchButton.addEventListener("click", searchProducts);

  // Enter key press event
  searchInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
      searchProducts();
    }
  });

  const displayItems = (items) => {
    rootElement.innerHTML = "";
    items.forEach((item) => {
      const div = document.createElement("div");
      div.classList.add("products");
      div.innerHTML = `
       <div class='box'>
        <div class='img-box'>
          <img class='img' src="${item.image}" alt="${item.title}">
        </div>
        <div class='bottom'>
          <h2>${item.title}</h2>
          <h4>${item.per}</h4>
          <h3>₹${item.price}.00</h3>
          <input type="hidden" name="Item_Name" value="${item.title}">
          <input type="hidden" name="Price" value="${item.price}">
          <input type="hidden" name="Item_Image" value="${item.image}">
        <button class="btn3 btn btn-success " onclick="addToCart('${item.title}', ${item.price}, '${item.image}')">
            Add Item
          </button>        </div>
      </div>
      `;
      rootElement.appendChild(div);
    });
  };

  // Initial display
  if (products.length > 0) {
    displayItems(products);
  }
});

// Global function to add items to cart
function addToCart(itemName, itemPrice, itemImage) {
  const formData = new FormData();
  formData.append('Item_Name', itemName);
  formData.append('Price', itemPrice);
  formData.append('Item_Image', itemImage);

  fetch('/manage_cart', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Update cart count in header
      const cartCountElement = document.querySelector('.cart-count');
      if (cartCountElement) {
        cartCountElement.textContent = data.count;
      }
      
      // Show success message
        showPopup(`${itemName} added to cart `, "success");
    } else {
      showPopup('Failed to add item to cart', 'error');
    }
  })
  .catch(error => {
    console.error('Error adding to cart:', error);
    showPopup('Error adding item to cart', 'error');
  });
}


function showPopup(message, type) {
  const popup = document.getElementById("popup");
  if (!popup) return;

  // message મૂકવું
  popup.innerHTML = `
    <div class="text-white">
      ${message}
    </div>
  `;

  // પહેલા થી hide class કાઢી નાખો
  popup.classList.remove("hide");
  popup.classList.add("show"); // show class add કરો

  // 3 second પછી auto-hide
  setTimeout(() => {
    closePopup();
  }, 3000);
}

function closePopup() {
  const popup = document.getElementById("popup");
  if (popup) {
    popup.classList.remove("show");
    popup.classList.add("hide");
    setTimeout(() => {
      popup.style.display = "none"; // remove after animation
    }, 500);
  }
}
