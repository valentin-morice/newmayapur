<template>
    <div>
        <div v-if="$page.props.isLogged"
             class="z-20 justify-center text-white fixed w-full flex bg-gray-800 py-2 px-6 gap-2">
            <Link href="/admin/overview">
                <button class="hover:bg-gray-700 py-1 px-2 border rounded border-white">Admin</button>
            </Link>
            <Link as="button" method="post" href="/logout">
                <p class="hover:bg-red-700 py-1 px-2 border rounded border-white">Logout</p>
            </Link>
        </div>
    </div>
    <Navbar :class="$page.props.isLogged ? 'pt-[3.6rem]' : ''"></Navbar>
    <slot></slot>
    <Footer></Footer>
</template>

<script>
import Navbar from '../Components/Navbar'
import Footer from "../Components/Footer";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Navbar,
        Footer,
        Link,
    }
}
</script>
