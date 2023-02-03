const output = document.querySelector("output")
const input = document.querySelector("#select-image")
let imagesArray = [];

input.addEventListener("change", () => {
    const files = input.files
    for (let i = 0; i < files.length; i++) {
      imagesArray.push(files[i])
    }
    displayImages()
  });

  function displayImages() {
    let images = ""
    imagesArray.forEach((image, index) => {
      images += `<div class="image">
                  <img src="${URL.createObjectURL(image)}" alt="image">
                  <span class="delete-btn" onclick="deleteImage(${index})">&times;</span>
                </div>`
    })
    output.innerHTML = images
  }

  function deleteImage(index) {
    imagesArray.splice(index, 1)
    displayImages()
  }
