<button
    id="nav-burger-menu-btn"
    aria-label="Menu"
    class="size-8 transition-transform duration-300 ease-in cursor-pointer scale-100 <?= $class ?? '' ?>">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="100%"
        height="100%"
        viewBox="0 0 36 36"
        fill="none"
        stroke="currentColor"
        stroke-width="4"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="lucide lucide-menu overflow-visible">
        <path class="burger burger-close -translate-y-2.25" d="M0 18h36" />
        <path class="transition-opacity duration-300 ease-in" d="M0 18h36" />
        <path class="burger burger-close translate-y-2.25" d="M0 18h36" />
    </svg>
</button>
