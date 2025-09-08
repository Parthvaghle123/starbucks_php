document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = "http://localhost:8080/"; // CHANGE as per your server
  const products = [
    {
      id: 0,
      image:
        "https://starbucksstatic.cognizantorderserv.com/Items/Small/100501.jpg",
      title: "Java Chip Frappuccino",
      per: "Mocha sauce and Frappuccino® chips blended with with Frappu..",
      price: 441,
    },
    {
      id: 1,
      image:
        "https://starbucksstatic.cognizantorderserv.com/Items/Small/112539.jpg",
      title: "Picco Cappuccino",
      per: "Dark, Rich in flavour espresso lies in wait under a smoothed..",
      price: 200,
    },
    {
      id: 2,
      image:
        "https://starbucksstatic.cognizantorderserv.com/Items/Small/100385.jpg",
      title: "Iced Caffe Latte",
      per: "Our dark, Rich in flavour espresso is combined with milk and..",
      price: 372,
    },
  ];

  const searchInput = document.getElementById("search");
  const searchButton = document.getElementById("searchButton");
  const messageBox = document.getElementById("messageBox");
  const rootElement = document.getElementById("root1");

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
      messageBox.style.display = "none";
    }
  });

  // Search button and form events
  searchButton.addEventListener("click", searchProducts);
  const form = document.querySelector("form");
  if (form) {
    form.addEventListener("submit", searchProducts);
  }

  // 📦 Display Items + Bind Add to Cart
  const displayItems = (items) => {
    rootElement.innerHTML = items
      .map(
        (item) => `
      <form class="cartForm">
        <div class='box'>
          <div class='img-box'>
            <img class='img' src="${item.image}" alt="${item.title}">
          </div>
          <div class='bottom'>
            <h2>${item.title}</h2>
            <h4>${item.per}</h4>
            <h5>₹${item.price}.00</h5>
            <input type="hidden" name="Item_Name" value="${item.title}">
            <input type="hidden" name="Price" value="${item.price}">
            <input type="hidden" name="Item_Image" value="${item.image}">
            <button type="submit" class="btn3 btn btn-success">Add Item</button>
          </div>
        </div>
      </form>
    `
      )
      .join("");

    // Add to cart form submission
    document.querySelectorAll(".cartForm").forEach((form) => {
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        try {
          const res = await fetch(`${baseUrl}manage_cart`, {
            method: "POST",
            body: formData,
          });
          const data = await res.json();

          if (data.status === "success") {
            showPopup(`${formData.get("Item_Name")} added to cart!`);
            const cartCountEl = document.getElementById("cartCount");
            if (cartCountEl) {
              cartCountEl.textContent = data.count; // update cart count safely
            }
          } else {
            showPopup("Failed to add item to cart.");
          }
        } catch (error) {
          console.error("Error adding to cart", error);
          showPopup("Server error, try again.");
        }
      });
    });
  };

  // Popup Function
  function showPopup(message) {
    const popup = document.getElementById("popup");
    if (popup) {
      popup.querySelector(
        ".popup-content"
      ).innerHTML = `<p class="fw-bold text-light">🛒${message}</p>`;
      popup.classList.add("show");
      popup.classList.remove("hide");
      popup.style.display = "block";

      setTimeout(() => {
        popup.classList.remove("show");
        popup.classList.add("hide");
        setTimeout(() => {
          popup.style.display = "none";
        }, 800);
      }, 2000);
    }
  }

  // Initial Load
  displayItems(products);
});
