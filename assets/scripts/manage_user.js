document.addEventListener("DOMContentLoaded", function () {
  // Search functionality
  const searchInput = document.getElementById("userSearch");
  const tableBody = document.querySelector(".users-table tbody");

  if (!tableBody) {
    console.error("Table body not found!");
    return;
  }

  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    const tableRows = tableBody.querySelectorAll("tr");

    tableRows.forEach((row) => {
      const usernameCell = row.cells[1];
      const username = usernameCell.textContent.toLowerCase().trim();

      row.style.display = username.includes(searchTerm) ? "" : "none";
    });
  });

  // Modal elements
  const removeModal = document.getElementById("removeModal");
  const banModal = document.getElementById("banModal");
  const removeUsername = document.getElementById("removeUsername");
  const banModalTitle = document.getElementById("banModalTitle");
  const banModalMessage = document.getElementById("banModalMessage");

  let currentUserId = null;
  let currentUsername = null;
  let currentStatus = null;

  // Role change handler
  document.querySelectorAll(".role-dropdown").forEach((dropdown) => {
    dropdown.addEventListener("change", function () {
      const userId = this.getAttribute("data-user-id");
      const newRole = this.value;

      const params = new URLSearchParams({
        action: "update_role",
        user_id: userId,
        new_role: newRole,
      });

      fetch(
        "/storynight/controllers/manageUserController.php?" + params.toString()
      )
        .then((res) => res.text())
        .then((text) => {
          try {
            const data = JSON.parse(text);
          } catch (e) {
            console.error("Not valid JSON:", e);
          }
        })
        .catch((err) => console.error("Fetch error:", err));
    });
  });

  // Remove button click
  document.querySelectorAll(".btn-remove").forEach((button) => {
    button.addEventListener("click", function () {
      currentUserId = this.getAttribute("data-user-id");
      currentUsername = this.getAttribute("data-username");
      removeUsername.textContent = currentUsername;
      removeModal.style.display = "block";
    });
  });

  // Ban/Unban button click
  document.querySelectorAll(".btn-ban").forEach((button) => {
    button.addEventListener("click", function () {
      currentUserId = this.getAttribute("data-user-id");
      currentStatus = this.getAttribute("data-status");
      const isBanned = currentStatus === "banned";

      banModalTitle.textContent = isBanned ? "Unban User" : "Ban User";
      banModalMessage.textContent = isBanned
        ? "Are you sure you want to unban this user?"
        : "Are you sure you want to ban this user?";

      banModal.style.display = "block";
    });
  });

  // Close modals
  document.querySelectorAll(".btn-cancel").forEach((button) => {
    button.addEventListener("click", function () {
      removeModal.style.display = "none";
      banModal.style.display = "none";
      currentUserId = null;
      currentUsername = null;
      currentStatus = null;
    });
  });

  // Confirm remove
  document
    .querySelector(".btn-confirm-remove")
    .addEventListener("click", function () {
      if (currentUserId) {
        const params = new URLSearchParams({
          action: "remove",
          user_id: currentUserId,
        });

        fetch(
          "/storynight/controllers/manageUserController.php?" +
            params.toString()
        )
          .then((res) => res.text())
          .then((text) => {
            try {
              const data = JSON.parse(text);
            } catch (e) {
              console.error("Not valid JSON:", e);
            }
          })
          .catch((err) => console.error("Fetch error:", err));
        removeModal.style.display = "none";
        // Reload
        setTimeout(() => {
          location.reload();
        }, 1000);
      }
    });

  // Confirm ban/unban
  document
    .querySelector(".btn-confirm-ban")
    .addEventListener("click", function () {
      if (currentUserId) {
        const action = currentStatus === "banned" ? "unban" : "ban";

        const params = new URLSearchParams({
          action: "toggle_status",
          user_id: currentUserId,
          current_status: currentStatus,
        });

        fetch(
          "/storynight/controllers/manageUserController.php?" +
            params.toString()
        )
          .then((res) => res.text())
          .then((text) => {
            try {
              const data = JSON.parse(text);
            } catch (e) {
              console.error("Not valid JSON:", e);
            }
          })
          .catch((err) => console.error("Fetch error:", err));
        banModal.style.display = "none";
        setTimeout(() => {
          location.reload();
        }, 1000);
      }
    });
});
