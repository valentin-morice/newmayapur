<template>
    <Navbar></Navbar>
    <slot></slot>
    <Footer></Footer>
</template>

<script>
import Navbar from '../Components/Navbar'
import Footer from "../Components/Footer";

export default {
    components: {
        Navbar,
        Footer
    }
}
</script>
