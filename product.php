<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PetPal Market - Products</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f7f7f7;
    }

    header {
      background: rgba(0, 0, 0, 0.8);
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: #ffd700;
    }

    nav {
      display: flex;
      gap: 2rem;
      position: relative;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 1rem;
      transition: color 0.3s;
      position: relative;
    }

    nav a:hover {
      color: #ffd700;
    }

    .hamburger {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        display: none;
        width: 100%;
        margin-top: 1rem;
      }

      nav.show {
        display: flex;
      }

      .hamburger {
        display: block;
        color: white;
      }
    }


    .cart {
      position: relative;
      font-size: 1.5rem;
      cursor: pointer;
      color: white;
    }

    .cart i:hover {
      color: #ffd700;
    }

    .cart span {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: red;
      color: white;
      border-radius: 50%;
      font-size: 0.75rem;
      padding: 2px 6px;
    }

    h2 {
      text-align: center;
      margin: 1.5rem 0;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
      padding: 1rem 2rem;
    }

    .product {
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      position: relative;
      display: flex;
      flex-direction: column;
    }

    .product:hover {
      transform: translateY(-5px);
    }

    .product-img-container {
      width: 100%;
      height: 200px;
      position: relative;
      overflow: hidden;
    }

    .product-img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 0.5s;
    }

    .product-img.active {
      opacity: 1;
    }

    .product-desc {
      position: absolute;
      top: 0;
      left: 0;
      width: 90%;
      height: 90%;
      background: rgba(0, 0, 0, 0.6);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 2;
      padding: 1rem;
    }

    .product-img-container:hover .product-desc {
      opacity: 1;
    }

    .product-body {
      padding: 1rem;
      text-align: center;
    }

    .product-body h3 {
      margin: 0.5rem 0;
    }

    .price {
      font-size: 1rem;
      font-weight: bold;
      color: #555;
      margin-bottom: 0.5rem;
    }

    .product-body button {
      padding: 0.5rem 1rem;
      margin: 0.3rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .add-btn {
      background-color: #222;
      color: #fff;
    }

    .buy-btn {
      background-color: #ffd700;
      color: #222;
    }

    #cartModal {
      display: none;
      position: fixed;
      top: 80px;
      right: 20px;
      width: 320px;
      max-height: 70vh;
      overflow-y: auto;
      background: white;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      z-index: 9999;
      padding: 1rem;
      border-radius: 10px;
    }

    #cartModal h3 {
      margin-top: 0;
      margin-bottom: 1rem;
    }

    #cartItems {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    #cartItems li {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    #cartItems img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 5px;
      margin-right: 10px;
      flex-shrink: 0;
    }

    #cartItems div {
      flex-grow: 1;
      font-size: 0.9rem;
    }

    #cartItems button,
    #cartItems i.fa-trash-alt {
      margin-left: 10px;
      cursor: pointer;
      padding: 4px 8px;
      border: none;
      font-weight: bold;
      border-radius: 5px;
    }

    #cartItems i.fa-trash-alt {
      color: red;
      font-size: 18px;
    }

    #buyAllBtn {
      margin-top: 10px;
      padding: 8px 12px;
      background: #ffd700;
      border: none;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      font-size: 1rem;
    }

    #totalAmount {
      text-align: right;
      font-weight: bold;
      margin-top: 10px;
      font-size: 1rem;
    }

    .toast {
      visibility: hidden;
      min-width: 250px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 8px;
      padding: 1rem 1.5rem;
      position: fixed;
      top: 30px;
      right: 30px;
      z-index: 999;
      font-size: 1.2rem;
      /* increased size */
      opacity: 0;
      transition: opacity 0.5s ease, top 0.5s ease;
    }

    .toast.show {
      visibility: visible;
      opacity: 1;
      top: 70px;
    }

    .modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.9);
      padding: 2rem;
      border-radius: 10px;
      color: white;
      display: none;
      z-index: 1000;
      width: 90%;
      max-width: 400px;
    }

    .modal.active {
      display: block;
    }

    .modal input {
      width: 100%;
      padding: 0.5rem;
      margin: 0.5rem 0;
      border: none;
      border-radius: 5px;
    }

    .modal button {
      padding: 0.5rem 1rem;
      background: #ffd700;
      border: none;
      cursor: pointer;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      margin-top: 1rem;
    }

    .modal .switch {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .modal .switch span {
      color: #ffd700;
      cursor: pointer;
      text-decoration: underline;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      font-size: 1.2rem;
    }

    .profile-container {
      position: relative;
    }

    .profile-details {
      display: none;
      position: absolute;
      background: #fff;
      color: #000;
      padding: 10px;
      border-radius: 8px;
      top: 120%;
      right: 0;
      z-index: 999;
      white-space: nowrap;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .profile-container:hover .profile-details {
      display: block;
    }
  </style>
</head>

<body>
  <header>
    <div class="logo">TyChOk</div>
    <div class="hamburger" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
    <nav id="mainNav">
      <a href="#">Dog</a>
      <a href="#">Cats</a>
      <a href="#">Birds</a>
      
    </nav>

    <!-- Flex container for cart and profile/login icons -->
    <div style="display: flex; align-items: center; gap: 1.5rem;">

      <!-- Cart Icon -->
      <div class="cart" onclick="checkLoginForCart()">
        <i class="fas fa-shopping-cart"></i>
        <span id="cartCount">0</span>
      </div>

      <!-- User Profile or Login Icon -->
      <?php if (isset($_SESSION['user'])): ?>
        <div class="profile-container" style="position: relative;">
          <i class="fas fa-user-circle profile-icon" style="color: white; font-size: 1.5rem; cursor: pointer;"></i>
          <div class="profile-details">
            <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
          </div>
        </div>
      <?php else: ?>
        <i class="fas fa-user" id="loginIcon" style="color: white; font-size: 1.5rem; cursor: pointer;"></i>
      <?php endif; ?>

    </div>
  </header>


  <h2>Dogs Product</h2>
  <div class="products" id="productList">
    <!-- Product Template -->
    <div class="product" data-price="700">
      <div class="product-img-container">
        <img src="dog1.jpg" class="product-img active" />
        <img src="dog1.2.jpg" class="product-img" />
        <img src="dog1.3.jpg" class="product-img" />
        <div class="product-desc">Protein-rich dog food with real chicken supports lean muscles, strong bones, and healthy digestion. Enriched with essential vitamins and minerals, it features tartar-control kibbles and suits all breeds.
</div>
      </div>
      <div class="product-body">
        <h3>Drools Adult Dry Dog Food Chicken and Egg</h3>
        <div class="price">₹700</div>
        <button class="add-btn">Add to Cart</button>
        <button class="buy-btn">Buy Now</button>
      </div>
    </div>

    <div class="product" data-price="400">
      <div class="product-img-container">
        <img src="dog2.jpg" class="product-img active" />
        <img src="dog2.1.jpg" class="product-img" />
        <img src="dog2.2.jpg" class="product-img" />
        <img src="dog2.3.jpg" class="product-img" />
        <div class="product-desc">Nourishing oatmeal and Manuka honey shampoo soothes skin, boosts shine, and hydrates. Features a long-lasting green apple scent. Safe for all breeds, including sensitive skin. Sulphate and paraben free.</div>
      </div>
      <div class="product-body">
        <h3>Petterati Dog Shampoo</h3>
        <div class="price">₹400</div>
        <button class="add-btn">Add to Cart</button>
        <button class="buy-btn">Buy Now</button>
      </div>
    </div>

    <div class="product" data-price="530">
      <div class="product-img-container">
        <img src="dog3.jpg" class="product-img active" />
        <img src="dog3.1.jpg" class="product-img" />
        <img src="dog3.2.jpg" class="product-img" />
        <img src="dog3.3.jpg" class="product-img" />
        <div class="product-desc">All-natural dehydrated pork bone, rich in protein and calcium, supports dental health and mental stimulation. Hard texture keeps medium to large dogs engaged. Clean, hygienic, and free from additives, antibiotics, hormones, and preservatives.</div>
      </div>
      <div class="product-body">
        <h3>Dental Chewing Bone for DogsDental Chewing Bone for Dogs</h3>
        <div class="price">₹530</div>
        <button class="add-btn">Add to Cart</button>
        <button class="buy-btn">Buy Now</button>
      </div>
    </div>

    <div class="product" data-price="295">
      <div class="product-img-container">
        <img src="dog4.jpg" class="product-img active" />
        <img src="dog4.1.jpg" class="product-img" />
        <img src="dog4.2.jpg" class="product-img" />
        <img src="dog4.3.jpg" class="product-img" />
        <div class="product-desc">Automatic pet water dispenser with siphon refill system ensures constant fresh water. Includes a removable stainless steel bowl for easy cleaning, suitable for food and water. Designed for all pets with a stylish look, easy setup, and made in India for reliable quality.
</div>
      </div>
      <div class="product-body">
        <h3>Stainless Steel Bowl</h3>
        <div class="price">₹295</div>
        <button class="add-btn">Add to Cart</button>
        <button class="buy-btn">Buy Now</button>
      </div>
    </div>
  </div>

  <!-- Cart Modal -->
  <div id="cartModal">
    <h3>Your Cart</h3>
    <ul id="cartItems"></ul>
    <div id="totalAmount">Total: ₹0</div>
    <button id="buyAllBtn">Buy All</button>
  </div>

  <div id="toast" class="toast">Enjoy shopping!</div>
  <div class="modal" id="loginModal">
    <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
    <h2>Login</h2>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="switch">Don't have an account? <span onclick="switchModal('loginModal','signupModal')">Sign Up</span></div>
  </div>

  <div class="modal" id="signupModal">
    <span class="close-btn" onclick="closeModal('signupModal')">&times;</span>
    <h2>Sign Up</h2>
    <form action="signup.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>
    <div class="switch">Already have an account? <span onclick="switchModal('signupModal','loginModal')">Login</span></div>
  </div>
  <script>
    let cart = [];
    let cartCount = 0;

    const cartCounter = document.getElementById("cartCount");
    const addBtns = document.querySelectorAll(".add-btn");
    const buyBtns = document.querySelectorAll(".buy-btn");
    const cartIcon = document.querySelector(".cart");
    const cartModal = document.getElementById("cartModal");
    const cartItems = document.getElementById("cartItems");
    const totalAmount = document.getElementById("totalAmount");

    const products = document.querySelectorAll(".product");

    // Auto-scroll images
    products.forEach(product => {
      const imgs = product.querySelectorAll(".product-img");
      let i = 0;
      setInterval(() => {
        imgs.forEach(img => img.classList.remove("active"));
        imgs[i].classList.add("active");
        i = (i + 1) % imgs.length;
      }, 2000);
    });

    addBtns.forEach((btn, i) => {
      btn.addEventListener("click", () => {
        fetch('checkLogin.php')
          .then(res => res.text())
          .then(data => {
            if (data === "1") {
              const product = products[i];
              const name = product.querySelector("h3").textContent;
              const img = product.querySelector(".product-img.active").src;
              const price = parseInt(product.dataset.price);

              const existing = cart.find(item => item.name === name);
              if (existing) {
                existing.quantity++;
              } else {
                cart.push({
                  name,
                  img,
                  quantity: 1,
                  price
                });
              }
              cartCount++;
              cartCounter.textContent = cartCount;
              updateCartUI();
            } else {
              alert("Please login to add items to cart.");
            }
          });
      });
    });

    buyBtns.forEach((btn, i) => {
      btn.addEventListener("click", () => {
        fetch('checkLogin.php')
          .then(res => res.text())
          .then(data => {
            if (data === "1") {
              const product = products[i];
              const name = product.querySelector("h3").textContent;
              const img = product.querySelector(".product-img.active").src;
              const price = parseInt(product.dataset.price);
              const item = [{
                name,
                img,
                price,
                quantity: 1
              }];
              sessionStorage.setItem("checkoutItems", JSON.stringify(item));
              window.location.href = "checkout.html";
            } else {
              alert("Please login to buy items.");
            }
          });
      });
    });

    cartIcon.addEventListener("click", () => {
      cartModal.style.display = cartModal.style.display === "block" ? "none" : "block";
    });

    function updateCartUI() {
      cartItems.innerHTML = "";
      let total = 0;

      cart.forEach((item, index) => {
        const itemTotal = item.quantity * item.price;
        total += itemTotal;

        const li = document.createElement("li");
        li.innerHTML = `
          <img src="${item.img}" />
          <div>
            <strong>${item.name}</strong><br>
            ₹${item.price} × ${item.quantity} = ₹${itemTotal}
          </div>
          <div>
            <button onclick="buyItem(${index})">Buy</button>
            <i class="fas fa-trash-alt" onclick="removeItem(${index})" title="Remove"></i>
          </div>
        `;
        cartItems.appendChild(li);
      });

      totalAmount.textContent = "Total: ₹" + total;
    }

    function removeItem(index) {
      cartCount -= cart[index].quantity;
      cart.splice(index, 1);
      cartCounter.textContent = cartCount;
      updateCartUI();
    }

    function buyItem(index) {
      const item = [cart[index]];
      sessionStorage.setItem("checkoutItems", JSON.stringify(item));
      window.location.href = "checkout.html";
    }

    document.getElementById("buyAllBtn").addEventListener("click", () => {
      if (cart.length === 0) return alert("Cart is empty!");
      sessionStorage.setItem("checkoutItems", JSON.stringify(cart));
      window.location.href = "checkout.html";
    });

    window.addEventListener("DOMContentLoaded", () => {
      const msg = sessionStorage.getItem("shopMessage");
      if (msg) {
        const toast = document.getElementById("toast");
        toast.textContent = msg;
        toast.classList.add("show");

        setTimeout(() => {
          toast.classList.remove("show");
          sessionStorage.removeItem("shopMessage");
        }, 3000);
      }

      // Your existing cart logic remains unchanged...
    });

    function openModal(id) {
      document.getElementById(id).classList.add("active");
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove("active");
    }

    function switchModal(fromId, toId) {
      document.getElementById(fromId).classList.remove("active");
      document.getElementById(toId).classList.add("active");
    }

    document.getElementById("loginIcon")?.addEventListener("click", () => {
      openModal("loginModal");
    });

    function checkLoginForCart() {
      fetch('checkLogin.php')
        .then(res => res.text())
        .then(data => {
          if (data === "1") {
            document.getElementById("cartModal").style.display = "block";
          } else {
            alert("Please login first.");
          }
        });
    }
  </script>
</body>

</html>