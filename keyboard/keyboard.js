const keyboard = {
    elements: {
        main: null,
        keysContainer: null,
        keys: []
    },
    eventHandlers: {
        oninput: null,
        onclose: null,
    },
    properties: {
        value: "",
        capsLock: false
    },
    init() {
        // elementos principales
        this.elements.main = document.createElement("div");
        this.elements.keysContainer = document.createElement("div");
        // elementos principale de configuracion
        this.elements.main.classList.add("keyboard", "keyboard--hidden")
        this.elements.keysContainer.classList.add("keyboard_keys")
        this.elements.keysContainer.appendChild(this._createKeys());
        this.elements.keys = this.elements.keysContainer.querySelectorAll(".keyboard_key");
        // añadir el DOM
        this.elements.main.appendChild(this.elements.keysContainer);
        document.body.appendChild(this.elements.main)

        //habilita el teclado
        document.querySelectorAll(".use-keyboard-input").forEach(element => {
            element.addEventListener("focus", () => {
                this.open(element.value, currentValue => {
                    element.value = currentValue;

                });
            });
            // Cerrar el teclado al perder el foco, pero no inmediatamente
            element.addEventListener("blur", () => {
                // Esperar un poco para permitir clics en las teclas
                setTimeout(() => {
                    if (!this.elements.keysContainer.contains(document.activeElement) && document.activeElement !== element) {
                        this.close();
                    }
                }, 200); 
            });
            // Prevenir la entrada del teclado físico
            element.addEventListener("keydown", (event) => {
                event.preventDefault(); 
            });

        });

        // Detener el cierre del teclado al hacer clic en las teclas
        this.elements.keysContainer.addEventListener("mousedown", (event) => {
            event.stopPropagation();
        });


    },

    _createKeys() {
        const fragment = document.createDocumentFragment();

        const number = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        const letters = ["q", "w", "e", "r", "t", "y", "u", "i", "o", "p",
            "a", "s", "d", "f", "g", "h", "j", "k", "l",
            "ñ", "z", "x", "c", "v", "b", "n", "m"];

        //funcion aleatoria
        const shuffleArray = (array) => {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }
        const shuffledNumbers = shuffleArray(number);
        const shuffledLetters = shuffleArray(letters);
        //teclas fijas
        const fixedKeys = {
            backspace: "backspace",
            caps: "caps",
            done: "done"
        };
        //disposicion del teclado
        const keyLayout = [
            ...shuffledNumbers, fixedKeys.backspace,
            ...shuffledLetters.slice(0, 10),
            ...shuffledLetters.slice(10, 20), fixedKeys.caps,
            ...shuffledLetters.slice(20), fixedKeys.done
        ];
        //insertar salto de linea
        const insertLineBreakPosition = [11, 21, 32, 40];

        // crear html para iconos
        const createIconHTML = (icon_name) => {
            return `<i class="material-icons">${icon_name}</i>`;
        };


        keyLayout.forEach((key, index) => {
            const keyElement = document.createElement("button");

            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard_key");
            switch (key) {
                case fixedKeys.backspace:
                    keyElement.classList.add("keyboard_key--wide");
                    keyElement.innerHTML = createIconHTML("backspace");
                    keyElement.addEventListener("click", () => {
                        this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
                        this._triggerEvent("oninput");
                    });
                    break;

                case fixedKeys.caps:
                    keyElement.classList.add("keyboard_key--wide", "keyboard_key--activatable");
                    keyElement.innerHTML = createIconHTML("keyboard_capslock");

                    keyElement.addEventListener("click", () => {
                        this._toggleCapsLock();
                        keyElement.classList.toggle("keyboard_key--active", this.properties.capsLock);
                    });
                    break;
                case fixedKeys.done:
                    keyElement.classList.add("keyboard_key--wide", "keyboard_key--dark");
                    keyElement.innerHTML = createIconHTML("check_circle");

                    keyElement.addEventListener("click", () => {
                        this.close();
                        this._triggerEvent("onclose");
                    });

                    break;
                default:
                    keyElement.textContent = key.toLowerCase();
                    keyElement.addEventListener("click", () => {
                        this.properties.value += this.properties.capsLock ? key.toUpperCase() : key.toLowerCase();
                        this._triggerEvent("oninput")
                    });
                    break;

            }
            fragment.appendChild(keyElement);
            if (insertLineBreakPosition.includes(index + 1)) {
                fragment.appendChild(document.createElement("br"));
            }
        });
        return fragment;
    },
    _triggerEvent(handlerName) {
        if (typeof this.eventHandlers[handlerName] == "function") {
            this.eventHandlers[handlerName](this.properties.value);
        }
    },
    _toggleCapsLock() {
        this.properties.capsLock = !this.properties.capsLock;

        document.querySelectorAll(".keyboard_key").forEach(keyElement => {
            if (keyElement.textContent.length === 1) {
                keyElement.textContent = this.properties.capsLock
                    ? keyElement.textContent.toUpperCase()
                    : keyElement.textContent.toLowerCase();
            }
        });
    },
    open(initialValue, oninput, onclose) {
        this.properties.value = initialValue || "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;

        //aleaotrizar
        this.elements.keysContainer.innerHTML = "";
        this.elements.keysContainer.appendChild(this._createKeys());
        this.elements.main.classList.remove("keyboard--hidden");
        setTimeout(() => {
            this.elements.main.classList.add("keyboard--visible");
        }, 10);
    },
    close() {

        this.elements.main.classList.remove("keyboard--visible");

        setTimeout(() => {
            this.properties.value = "";
            this.eventHandlers.oninput = null; 
            this.eventHandlers.onclose = null; 
            this.elements.main.classList.add("keyboard--hidden");
        }, 300); 

    }
};
window.addEventListener("DOMContentLoaded", function () {
    keyboard.init();

})
