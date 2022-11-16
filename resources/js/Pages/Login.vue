<template>
    <div class="bg-base-200 h-screen py-8 flex items-center justify-center px-2 lg:px-0 py-64">
        <div class="shadow-lg bg-white md:w-2/3 lg:w-1/3 mx-auto p-4 rounded-xl">
            <h1 class="font-bold text-xl text-gray-700 mb-4">Login</h1>
            <form @submit.prevent="submit">
                <input
                    v-model="form.email"
                    class="mt-3 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="email"
                    placeholder="Your Email"
                    type="email">
                <p v-if="form.errors.email" class=" mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
                <input
                    v-model="form.password"
                    class="mt-3 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="password"
                    placeholder="Password"
                    type="password">
                <p v-if="form.errors.password" class=" mt-1 text-sm text-red-500">{{ form.errors.password }}</p>
                <div class="flex mt-6 mb-2 gap-2">
                    <Link
                        class="bg-blue-500 text-center w-full hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        href="/">Go Back
                    </Link>
                    <button
                        class="bg-blue-500 w-full hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
        })
        return {form}
    },
    methods: {
        submit() {
            this.form.post('/login');
        }
    }
}
</script>
