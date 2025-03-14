function generatePassengerIcons(totalSlots, occupiedSlots) {
    let icons = "";
  
    for (let i = 0; i < totalSlots; i++) {
      icons += `<i class="fa fa-user" style="color: ${i < occupiedSlots ? 'black' : 'lightgray'};"></i> `;
    }
  
    return icons;
  }