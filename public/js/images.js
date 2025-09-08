  document.addEventListener("DOMContentLoaded", () => {
      const products = [
        {
          id: 0,
          image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/100501.jpg",
          title: "Bestseller",
        },
        {
          id: 1,
          image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/103973.jpg",
          title: "Drinks",
        },
        {
          id: 2,
          image: "https://starbucksstatic.cognizantorderserv.com/Category/Small/Food.jpg",
          title: "Food",
        },
        {
          id: 3,
          image: "https://starbucksstatic.cognizantorderserv.com/Category/Small/Merchandise.jpg",
          title: "Merchandise",
        },
        {
          id: 4,
          image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/104108.jpg",
          title: "Cheese Toast",
        },
        {
          id: 5,
          image: "https://starbucksstatic.cognizantorderserv.com/Items/Small/116858.png",
          title: "Chicken Sandwich",
        },
      ];
      const displayItems = (items) => {
        let rootElement = document.getElementById("root");
        rootElement.innerHTML = "";
        items.forEach((item) => {
          let div = document.createElement("div");
          div.classList.add("products");
          div.innerHTML = `
        <div class='img-box1'>
          <img class='images' src="${item.image}" alt="${item.title}">
          </div>
        <h6 class="text-center">${item.title}</h6>
            `;
          rootElement.appendChild(div);
        });
      };
      displayItems(products);
    });
    
    