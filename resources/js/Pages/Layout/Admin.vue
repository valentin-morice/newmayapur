<template>
    <div class="drawer drawer-mobile">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle"/>
        <div class="bg-base-200 drawer-content flex flex-col items-start justify-start">
            <slot></slot>
            <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">Open drawer</label>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 space-y-2 bg-base-100 text-base-content">
                <!-- Sidebar content here -->
                <li :class="url.includes('overview') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/overview">Overview</Link>
                </li>
                <li :class="url.includes('members') ? 'bg-base-200 rounded-[8px]' : ''">
                    <Link href="/admin/members">All Members</Link>
                </li>
            </ul>
            <Link href="/" class="btn btn-primary m-4 self-end w-100">
                &#171; Back
            </Link>
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
.calculate {
    width: calc(100vw - 22rem);
}
</style>
