import Swal from "sweetalert2";

/**
 * Configuração global do SweetAlert2
 * Define temas e estilos padrão para a aplicação
 */

// Confirmar ação (com OK e Cancelar)
export const confirmAlert = (title, message = "") => {
    return Swal.fire({
        title: title,
        text: message,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3b82f6",
        cancelButtonColor: "#ef4444",
        confirmButtonText: "Sim, continuar",
        cancelButtonText: "Cancelar",
        background: "#1f2937",
        color: "#fff",
        didOpen: (modal) => {
            modal.style.borderRadius = "0.5rem";
        },
    });
};

// Sucesso
export const successAlert = (title, message = "") => {
    return Swal.fire({
        title: title,
        text: message,
        icon: "success",
        confirmButtonColor: "#3b82f6",
        background: "#1f2937",
        color: "#fff",
        didOpen: (modal) => {
            modal.style.borderRadius = "0.5rem";
        },
    });
};

export const successToast = (title, message = "") => {
    return Swal.fire({
        title: title,
        text: message,
        icon: "success",
        background: "#1f2937",
        color: "#fff",
        showCloseButton: true,
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
};

// Erro
export const errorAlert = (title, message = "") => {
    return Swal.fire({
        title: title,
        text: message,
        icon: "error",
        confirmButtonColor: "#3b82f6",
        background: "#1f2937",
        color: "#fff",
        didOpen: (modal) => {
            modal.style.borderRadius = "0.5rem";
        },
    });
};

// Info
export const infoAlert = (title, message = "") => {
    return Swal.fire({
        title: title,
        text: message,
        icon: "info",
        confirmButtonColor: "#3b82f6",
        background: "#1f2937",
        color: "#fff",
        didOpen: (modal) => {
            modal.style.borderRadius = "0.5rem";
        },
    });
};

export default Swal;
