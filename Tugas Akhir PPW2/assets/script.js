// Global JavaScript functions
document.addEventListener("DOMContentLoaded", () => {
  // Initialize page-specific functions
  initializeSearch()
  initializeForms()
  initializeTable()
})

// Search functionality
function initializeSearch() {
  const searchInput = document.getElementById("searchInput")
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase()
      filterTable(searchTerm)
    })
  }
}

function filterTable(searchTerm) {
  const table = document.querySelector(".data-table table")
  if (!table) return

  const rows = table.querySelectorAll("tbody tr")
  rows.forEach((row) => {
    const text = row.textContent.toLowerCase()
    row.style.display = text.includes(searchTerm) ? "" : "none"
  })
}

// Form validation and submission
function initializeForms() {
  const forms = document.querySelectorAll("form")
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      if (!validateForm(this)) {
        e.preventDefault()
      }
    })
  })
}

function validateForm(form) {
  let isValid = true
  const requiredFields = form.querySelectorAll("[required]")

  requiredFields.forEach((field) => {
    if (!field.value.trim()) {
      showError(field, "Field ini wajib diisi")
      isValid = false
    } else {
      clearError(field)
    }
  })

  // Email validation
  const emailFields = form.querySelectorAll('input[type="email"]')
  emailFields.forEach((field) => {
    if (field.value && !isValidEmail(field.value)) {
      showError(field, "Format email tidak valid")
      isValid = false
    }
  })

  // Password confirmation
  const password = form.querySelector('input[name="password"]')
  const confirmPassword = form.querySelector('input[name="confirm_password"]')
  if (password && confirmPassword && password.value !== confirmPassword.value) {
    showError(confirmPassword, "Password tidak cocok")
    isValid = false
  }

  return isValid
}

function showError(field, message) {
  field.classList.add("error")
  let errorDiv = field.parentNode.querySelector(".error-message")
  if (!errorDiv) {
    errorDiv = document.createElement("div")
    errorDiv.className = "error-message"
    field.parentNode.appendChild(errorDiv)
  }
  errorDiv.textContent = message
}

function clearError(field) {
  field.classList.remove("error")
  const errorDiv = field.parentNode.querySelector(".error-message")
  if (errorDiv) {
    errorDiv.remove()
  }
}

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}

// Table functionality
function initializeTable() {
  // Add sorting functionality
  const headers = document.querySelectorAll(".data-table th")
  headers.forEach((header, index) => {
    header.style.cursor = "pointer"
    header.addEventListener("click", () => sortTable(index))
  })
}

function sortTable(columnIndex) {
  const table = document.querySelector(".data-table table")
  const tbody = table.querySelector("tbody")
  const rows = Array.from(tbody.querySelectorAll("tr"))

  const isAscending = table.getAttribute("data-sort-direction") !== "asc"
  table.setAttribute("data-sort-direction", isAscending ? "asc" : "desc")

  rows.sort((a, b) => {
    const aText = a.cells[columnIndex].textContent.trim()
    const bText = b.cells[columnIndex].textContent.trim()

    // Check if it's a number
    const aNum = Number.parseFloat(aText.replace(/[^\d.-]/g, ""))
    const bNum = Number.parseFloat(bText.replace(/[^\d.-]/g, ""))

    if (!isNaN(aNum) && !isNaN(bNum)) {
      return isAscending ? aNum - bNum : bNum - aNum
    }

    return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText)
  })

  rows.forEach((row) => tbody.appendChild(row))
}

// AJAX functions
function makeAjaxRequest(url, method = "GET", data = null) {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest()
    xhr.open(method, url, true)
    xhr.setRequestHeader("Content-Type", "application/json")

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText)
            resolve(response)
          } catch (e) {
            resolve(xhr.responseText)
          }
        } else {
          reject(new Error("Request failed: " + xhr.status))
        }
      }
    }

    xhr.send(data ? JSON.stringify(data) : null)
  })
}

// Utility functions
function showLoading(element) {
  element.innerHTML = '<div class="loading"></div>'
}

function hideLoading(element, originalContent) {
  element.innerHTML = originalContent
}

function showMessage(message, type = "success") {
  const messageDiv = document.createElement("div")
  messageDiv.className = `message ${type}-message fade-in`
  messageDiv.textContent = message
  messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        background: ${type === "success" ? "#059669" : "#dc2626"};
    `

  document.body.appendChild(messageDiv)

  setTimeout(() => {
    messageDiv.remove()
  }, 3000)
}

// Format currency
function formatCurrency(amount) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(amount)
}

// Format time
function formatTime(timeString) {
  const date = new Date(timeString)
  return date.toLocaleTimeString("id-ID", {
    hour: "2-digit",
    minute: "2-digit",
  })
}
