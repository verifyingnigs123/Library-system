<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f0f4f8;
    }

    header {
      background: #007bff;
      color: white;
      padding: 15px 20px;
      font-size: 1.2em;
    }

    .nav {
      display: flex;
      background: #e9ecef;
      padding: 10px;
      gap: 15px;
    }

    .nav button {
      background: white;
      border: 1px solid #ccc;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
    }

    .nav button:hover {
      background: #d6d6d6;
    }

    .section {
      display: none;
      padding: 20px;
    }

    .visible {
      display: block;
    }

    input, select {
      padding: 8px;
      width: 100%;
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }

    button.submit {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      margin-top: 10px;
    }

    button.submit:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <header>📚 Library Dashboard</header>
  <div class="nav">
    <button onclick="showSection('userManagement')">User Management</button>
    <button onclick="showSection('bookManagement')">Book Management</button>
    <button onclick="showSection('borrowBook')">Borrow Book</button>
    <button onclick="showSection('returnBook')">Return Book</button>
    <button onclick="showSection('history')">Borrowing History</button>
  </div>

  <!-- User Management -->
  <div class="section" id="userManagement">
    <h2>User Management</h2>
    <input type="text" id="newUsername" placeholder="Enter username" />
    <input type="email" id="newUserEmail" placeholder="Enter email" />
    <button class="submit" onclick="addUser()">Add User</button>
    <h3>Registered Users</h3>
    <ul id="userList"></ul>
  </div>

  <!-- Book Management -->
  <div class="section" id="bookManagement">
    <h2>Book Management</h2>
    <input type="text" id="bookTitle" placeholder="Book title" />
    <input type="text" id="bookAuthor" placeholder="Author" />
    <button class="submit" onclick="addBook()">Add Book</button>
    <h3>Available Books</h3>
    <ul id="bookList"></ul>
  </div>

  <div class="section" id="borrowBook">
    <h2>Borrow Book</h2>
    <label for="borrowUser">Select User:</label>
    <select id="borrowUser"></select>
  
    <label for="borrowBookSelect">Select Book:</label>
    <select id="borrowBookSelect"></select>
  
    <button class="submit" onclick="borrowBook()">Borrow</button>
  </div>

  <!-- Return Book -->
  <div class="section" id="returnBook">
    <h2>Return Book</h2>
    <select id="returnSelect"></select>
    <button class="submit" onclick="returnBook()">Return</button>
  </div>

  <!-- Borrowing History -->
  <div class="section" id="history">
    <h2>Borrowing History</h2>
    <table>
      <thead>
        <tr>
          <th>User</th>
          <th>Book</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="historyTable"></tbody>
    </table>
  </div>

  <script>
let users = [];
let books = [];
let borrowHistory = [];

function showSection(sectionId) {
  document.querySelectorAll('.section').forEach(sec => sec.classList.remove('visible'));
  document.getElementById(sectionId).classList.add('visible');
  updateUI();
}

function addUser() {
  const name = document.getElementById("newUsername").value.trim();
  const email = document.getElementById("newUserEmail").value.trim();
  if (name && email) {
    users.push({ name, email });
    document.getElementById("newUsername").value = '';
    document.getElementById("newUserEmail").value = '';
    updateUI();
  }
}

function addBook() {
  const title = document.getElementById("bookTitle").value.trim();
  const author = document.getElementById("bookAuthor").value.trim();
  if (title && author) {
    books.push({ title, author, available: true });
    document.getElementById("bookTitle").value = '';
    document.getElementById("bookAuthor").value = '';
    updateUI();
  }
}

function borrowBook() {
  const userIndex = document.getElementById("borrowUser").value;
  const bookIndex = document.getElementById("borrowBookSelect").value;

  if (userIndex !== "" && bookIndex !== "") {
    const user = users[userIndex];
    const book = books[bookIndex];

    if (book.available) {
      borrowHistory.push({ user: user.name, book: book.title, status: 'Borrowed' });
      books[bookIndex].available = false; // mark as borrowed
      updateUI();
      alert(`${user.name} has borrowed "${book.title}".`);
    } else {
      alert("This book is not available.");
    }
  }
}

function returnBook() {
  const selected = document.getElementById("returnSelect").value;
  const index = parseInt(selected);

  if (!isNaN(index)) {
    const borrowedBook = borrowHistory[index];
    borrowedBook.status = 'Returned';

    // Find and mark the book as available
    const book = books.find(b => b.title === borrowedBook.book);
    if (book) book.available = true;

    updateUI();
    alert(`"${borrowedBook.book}" has been returned.`);
  }
}

function updateUI() {
  // User list display
  const userList = document.getElementById("userList");
  userList.innerHTML = '';
  users.forEach(user => {
    const li = document.createElement("li");
    li.textContent = `${user.name} (${user.email})`;
    userList.appendChild(li);
  });

  // Book list display
  const bookList = document.getElementById("bookList");
  bookList.innerHTML = '';
  books.forEach(book => {
    const li = document.createElement("li");
    li.textContent = `${book.title} by ${book.author} - ${book.available ? '✅ Available' : '❌ Borrowed'}`;
    bookList.appendChild(li);
  });

  // Borrow User dropdown
  const borrowUser = document.getElementById("borrowUser");
  borrowUser.innerHTML = '<option value="">Select User</option>';
  users.forEach((user, i) => {
    const option = document.createElement("option");
    option.value = i;
    option.textContent = user.name;
    borrowUser.appendChild(option);
  });

  // Borrow Book dropdown (only available books)
  const borrowBookSelect = document.getElementById("borrowBookSelect");
  borrowBookSelect.innerHTML = '<option value="">Select Book</option>';
  books.forEach((book, i) => {
    if (book.available) {
      const option = document.createElement("option");
      option.value = i;
      option.textContent = `${book.title} by ${book.author}`;
      borrowBookSelect.appendChild(option);
    }
  });

  // Return Book dropdown (only borrowed entries)
  const returnSelect = document.getElementById("returnSelect");
  returnSelect.innerHTML = '<option value="">Select to Return</option>';
  borrowHistory.forEach((entry, index) => {
    if (entry.status === 'Borrowed') {
      const option = document.createElement("option");
      option.value = index;
      option.textContent = `${entry.user} → ${entry.book}`;
      returnSelect.appendChild(option);
    }
  });

  // Borrowing History Table
  const table = document.getElementById("historyTable");
  table.innerHTML = '';
  borrowHistory.forEach(entry => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${entry.user}</td>
      <td>${entry.book}</td>
      <td>${entry.status}</td>
    `;
    table.appendChild(row);
  });
}

// Optional: Auto-borrow simulation every 10 seconds (can be removed)
setInterval(() => {
  if (users.length && books.some(b => b.available)) {
    const user = users[Math.floor(Math.random() * users.length)];
    const book = books.find(b => b.available);
    if (book) {
      borrowHistory.push({ user: user.name, book: book.title, status: 'Borrowed' });
      book.available = false;
      updateUI();
    }
  }
}, 10000);

  </script>
</body>
</html>
