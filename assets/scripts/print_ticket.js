// Print button 
document.querySelectorAll(".btn-print").forEach((btn) => {
  btn.addEventListener("click", function () {
    const bookingId = this.getAttribute("data-id");
    // this.dataset.id; 
    const card = this.closest(".movie-card");
    generateTicketPDF(card, bookingId);
  });
});

// Generate PDF ticket
function generateTicketPDF(card, bookingId) {
  // Get movie details 
  const title = card.querySelector("h3").textContent;
  const genre = card.querySelector(".movie-genre").textContent.split(" • ")[0];
  const details = card.querySelectorAll(".movie-details p");

  const hall = details[0].textContent.replace("Hall: ", "");
  const date = details[1].textContent.replace("Date: ", "");
  const time = details[2].textContent.replace("Time: ", "");
  const seats = details[3].textContent.replace("Seats: ", "");
  const bookingDate = details[4].textContent.replace("Booked on: ", "");
  const price = card.querySelector(".price").textContent;

  // Create PDF 
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // PDF Design //

  // Logo
  doc.setFillColor(40, 40, 40);
  doc.rect(0, 0, 210, 30, "F");
  doc.setFontSize(20);
  doc.setTextColor(255, 204, 0);
  doc.text("StoryNight Cinema", 105, 15, { align: "center" });

  // Ticket title
  doc.setFontSize(16);
  doc.setTextColor(0, 0, 0);
  doc.text("E-TICKET", 105, 45, { align: "center" });

  // Movie details
  doc.setFontSize(12);
  doc.setTextColor(0, 0, 0);

  // Ticket outline
  doc.setDrawColor(0, 0, 0);
  doc.setLineWidth(0.5);
  doc.roundedRect(20, 50, 170, 100, 3, 3);

  // Movie title
  doc.setFont(undefined, "bold");
  doc.text(`Movie: ${title}`, 25, 60);
  doc.setFont(undefined, "normal");

  // Other details
  doc.text(`Genre: ${genre}`, 25, 70);
  doc.text(`Hall: ${hall}`, 25, 80);
  doc.text(`Date: ${date}`, 25, 90);
  doc.text(`Time: ${time}`, 25, 100);
  doc.text(`Seats: ${seats}`, 25, 110);
  doc.text(`Booking Date: ${bookingDate}`, 25, 120);

  // Price and booking ID
  doc.text(`Total: ${price}`, 25, 130);
 doc.text(`Booking ID: ${bookingId}`, 105, 60,{ align: "center" });

  // Ticket footer
  doc.setFontSize(10);
  doc.setTextColor(100, 100, 100);
  doc.text("Please present this ticket at the entrance.", 105, 160, {
    align: "center",
  });
  doc.text("No refunds or exchanges allowed.", 105, 165, { align: "center" });

  // Date
  const now = new Date();
  doc.text(`Generated: ${now.toLocaleString()}`, 105, 175, { align: "center" });

  // Save the PDF
  doc.save(`ticket-${bookingId}.pdf`);
}
