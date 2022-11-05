<template>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-compact dropdown-content space-y-1 mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <Link href="/donate">Donate</Link>
                    </li>
                    <li>
                        <Link href="/login">Login</Link>
                    </li>
                </ul>
            </div>
            <Link href="/" class="btn btn-ghost normal-case text-xl">daisyUI</Link>
        </div>
        <div class="navbar-end">
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal p-0 space-x-2 ml-2">
                    <li>
                        <Link href="/donate">Donate</Link>
                    </li>
                    <li v-if="!$page.props.isLogged">
                        <Link href="/login">Login</Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link
    }
}
</script>
