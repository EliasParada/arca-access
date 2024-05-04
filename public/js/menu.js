const openMenu = document.querySelector("#open-menu");
const closeMenu = document.querySelector("#close-menu");
const aside = document.querySelector("aside");

openMenu.addEventListener("click", () => {
    aside.classList.add("aside-visible");
})

closeMenu.addEventListener("click", () => {
    aside.classList.remove("aside-visible");
})

function cargarProductos(productosElegidos, categoria = null) {
    productosElegidos.forEach(producto => {
        if (!categoria || producto.dataset.categoria.toLowerCase() === categoria.toLowerCase()) {
            producto.style.display = "block";
        } else {
            producto.style.display = "none";
        }
    });
}

const botonesCategorias = document.querySelectorAll(".boton-categoria");
const productos = document.querySelectorAll(".producto-card");

// Asigna un identificador a cada botón de categoría basado en su ID de categoría
botonesCategorias.forEach(boton => {
    boton.addEventListener("click", (e) => {
        const categoriaSeleccionada = e.currentTarget.id;
        botonesCategorias.forEach(boton => boton.classList.remove("active"));
        e.currentTarget.classList.add("active");
        if (categoriaSeleccionada !== "todos") {
            cargarProductos(productos, categoriaSeleccionada);
        } else {
            cargarProductos(productos);
        }
    });
});