<template>
    <div>
        <div v-if="$page.props.isLogged" class="z-20 text-white fixed w-full flex bg-gray-800 py-2 px-6 gap-6">
            <Link href="/admin/overview">
                <p class="hover:text-orange-500">Admin</p>
            </Link>
            <Link as="button" method="post" href="/logout">
                <p class="hover:text-orange-500">Logout</p>
            </Link>
        </div>
    </div>
    <Navbar :class="$page.props.isLogged ? 'pt-12' : ''"></Navbar>
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
