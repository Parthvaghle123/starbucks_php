document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = "http://localhost:8080/"; // CHANGE as per your server
  let products = []; // Will be populated from database

  const searchInput = document.getElementById("search");
  const searchButton = document.getElementById("searchButton");
  const messageBox = document.getElementById("messageBox");
  const rootElement = document.getElementById("root");

  // Load products from database on page load
  loadProductsFromDatabase();

  function loadProductsFromDatabase() {
    messageBox.style.display = "block";
    messageBox.className = "alert alert-success"; // Loading message in blue
    messageBox.textContent = "Loading products...";

    setTimeout(() => {
      fetch("/api/products/gift")
        .then((response) => response.json())
        .then((data) => {
          if (data.error)
            throw new Error(data.message || "Failed to load products");
          products = data;
          displayItems(products);
        })
        .catch((error) => {
          console.error("Error loading products:", error);
          messageBox.textContent =
            "Error loading products. Using fallback data.";
          messageBox.className = "alert alert-warning"; // fallback warning
          setTimeout(() => {
            loadFallbackProducts();
          }, 1000);
        });
    }, 400);
  }

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
        per: "Starbucks is best when shared. Treat your pals to a good cup of coffee.",
        price: 88,
      },
      {
        id: 2,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/7c6f7c64_3f89_4ba2_9af8_45fc6d94ad35_1_1bdd3bf075.webp",
        title: "Keep Me Warm",
        per: "Captivating, cosy, coffee. Gift your loved ones this Starbucks Gift Card.",
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
        per: "Nothing like a cup of coffee to flame a friendship. Share the experience with your..",
        price: 40,
      },
      {
        id: 5,
        image:
          "https://preprodtsbstorage.blob.core.windows.net/cms/uploads/61c1abaf_3b0f_48af_903e_426c1b9dae41_1_9a59b0ea34.webp",
        title: "Way To Go",
        per: "Its time to celebrate! Show your appreciation with this Starbucks Gift Card.",
        price: 80,
      },
    ];
    displayItems(products);
    messageBox.style.display = "none";
  }

  function searchProducts(event) {
    if (event) event.preventDefault();
    messageBox.style.display = "block";
    messageBox.className = "alert alert-warning"; // Searching message yellow
    messageBox.textContent = "Searching...";
    rootElement.innerHTML = "";

    setTimeout(() => {
      filterAndDisplayItems();
    }, 1000); // simulate delay
  }

  const filterAndDisplayItems = () => {
    const searchData = searchInput.value.toLowerCase();
    const filteredData = products.filter((item) =>
      item.title.toLowerCase().includes(searchData)
    );
    displayItems(filteredData);
  };

  searchInput.addEventListener("input", () => {
    if (searchInput.value === "") {
      displayItems(products);
    }
  });

  searchButton.addEventListener("click", searchProducts);

  searchInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") searchProducts();
  });

  const displayItems = (items) => {
    rootElement.innerHTML = "";

    if (!items || items.length === 0) {
      messageBox.style.display = "block";
      messageBox.className = "alert alert-danger"; // ✅ FIXED
      messageBox.textContent = "No products found ";
      return;
    }

    messageBox.style.display = "none";
    messageBox.className = "";

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
            <button class="btn3 btn btn-success" onclick="addToCart('${item.title}', ${item.price}, '${item.image}')">
              Add Item
            </button>
          </div>
        </div>
      `;
      rootElement.appendChild(div);
    });
  };
});

// --------------------- ADD TO CART ---------------------
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
        const cartCountElement = document.querySelector(".cart-count");
        if (cartCountElement) cartCountElement.textContent = data.count;
        showPopup(`${itemName} added to cart`, "success");
      } else {
        showPopup("Failed to add item to cart", "error");
      }
    })
    .catch((error) => {
      console.error("Error adding to cart:", error);
      showPopup("Error adding item to cart", "error");
    });
}

// --------------------- POPUP MESSAGE ---------------------
function showPopup(message, type) {
  const popup = document.getElementById("popup");
  if (!popup) return;

  popup.innerHTML = `<div class="text-white">${message}</div>`;
  popup.classList.remove("hide");
  popup.classList.add("show");

  setTimeout(closePopup, 3000);
}

function closePopup() {
  const popup = document.getElementById("popup");
  if (popup) {
    popup.classList.remove("show");
    popup.classList.add("hide");
    setTimeout(() => {
      popup.style.display = "none";
    }, 500);
  }
}
