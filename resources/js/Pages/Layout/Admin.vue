<template>
    <div class="drawer drawer-mobile">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle"/>
        <div class="bg-base-200 drawer-content flex flex-col items-start justify-start">
            <label for="my-drawer-2"
                   class="bg-white shadow-md p-3 cursor-pointer rounded m-4 w-100 drawer-button lg:hidden">
                <ion-icon class="text-4xl font-bold" name="menu-outline"></ion-icon>
            </label>
            <slot></slot>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <ul class="menu p-4 h-screen w-80 space-y-2 bg-base-100 text-base-content">
                <!-- Sidebar content here -->
                <li :class="url.includes('overview') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/overview">Overview</Link>
                </li>
                <li :class="url.includes('members') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/members">All Members</Link>
                </li>
                <li :class="url.includes('payments') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/payments">All Payments</Link>
                </li>
                <li :class="url.includes('export') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/export">Tools</Link>
                </li>
                <li>
                    <Link href="/" class="btn btn-primary mt-6 text-white w-100">
                        &#171; Back
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    computed: {
        url() {
            return window.location.href
        }
    }
}
</script>

<style>
@media (min-width: 1023px) {
    .calculate {
        width: calc(100vw - 22rem);
    }
}
</style>
