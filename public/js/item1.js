document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = "http://localhost:8080/"; // CHANGE as per your server
  let products = []; // Will be populated from database

  const searchInput = document.getElementById("search");
  const searchButton = document.getElementById("searchButton");
  const messageBox = document.getElementById("messageBox");
  const rootElement = document.getElementById("root");

  // Load products from database on page load
  loadProductsFromDatabase();

  // Function to load products from database
  function loadProductsFromDatabase() {
    console.log("Loading products from database...");
    messageBox.style.display = "block";
    messageBox.textContent = "Loading products...";

    console.log("Fetching from /api/products/gift");
    fetch("/api/products/gift")
      .then((response) => {
        console.log("Response received:", response);
        return response.json();
      })
      .then((data) => {
        console.log("Data received:", data);
        if (data.error) {
          throw new Error(data.message || "Failed to load products");
        }
        products = data;
        console.log("Products loaded:", products);
        displayItems(products);
        messageBox.style.display = "none";
      })
      .catch((error) => {
        console.error("Error loading products:", error);
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
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/TSB_GC_indiacard_1_1_28dafb2bb6.png",
        title: "India Exclusive",
        per: "Bring in the festive season and make each celebration memorable.",
        price: 99,
      },
      {
        id: 1,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/71d3780c_be6e_46b1_ab01_8a2bce244a7f_1_1_2d1afadaa0.png",
        title: "Starbucks Coffee",
        per: " Starbucks is best when shared. Treat your pals to a good cup of coffee.",
        price: 88,
      },
      {
        id: 2,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/7c6f7c64_3f89_4ba2_9af8_45fc6d94ad35_1_1bdd3bf075.webp",
        title: "Keep Me Warm",
        per: "  Captivating, cosy, coffee. Gift your loved ones this Starbucks Gift Card.",
        price: 50,
      },
      {
        id: 3,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/ff96761f_7c0a_4960_84a8_2a94c7d994fc_f59ad13bec.png",
        title: "Good Things Ahead",
        per: "Have a cup of coffee, its all good from here.",
        price: 110,
      },
      {
        id: 4,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/2822e5c5_38ff_422a_a225_cfc3a6bdfc06_1_fdcaafd8bd.png",
        title: "My Treat",
        per: "  Nothing like a cup of coffee to flame a friendship. Share the experience with your..",
        price: 40,
      },
      {
        id: 5,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/61c1abaf_3b0f_48af_903e_426c1b9dae41_1_9a59b0ea34.webp",
        title: "Way To Go",
        per: " Its time to celebrate! Show your appreciation with this Starbucks Gift Card.",
        price: 80,
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
    console.log("Displaying items:", items);
    console.log("Root element:", rootElement);

    if (!rootElement) {
      console.error("Root element not found!");
      return;
    }

    rootElement.innerHTML = "";
    console.log("Cleared root element");

    items.forEach((item, index) => {
      console.log(`Creating item ${index}:`, item);
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
      console.log(`Added item ${index} to DOM`);
    });

    console.log("Finished displaying items");
  };

  // Initial display
  if (products.length > 0) {
    displayItems(products);
  }
});

// Global function to add items to cart
function addToCart(itemName, itemPrice, itemImage) {
  const formData = new FormData();
  formData.append("Item_Name", itemName);
  formData.append("Price", itemPrice);
  formData.append("Item_Image", itemImage);

  fetch("/manage_cart", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        // Update cart count in header
        const cartCountElement = document.querySelector(".cart-count");
        if (cartCountElement) {
          cartCountElement.textContent = data.count;
        }

        // Show success message
        showPopup(`${itemName} added to cart `, "success");
      } else {
        showPopup("Failed to add item to cart", "error");
      }
    })
    .catch((error) => {
      console.error("Error adding to cart:", error);
      showPopup("Error adding item to cart", "error");
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
