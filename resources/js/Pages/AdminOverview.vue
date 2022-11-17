<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">Membership Overview</h1>
        <div class="calculate grid grid-cols-1 md:grid-cols-2 m-4 gap-4">
            <div>
                <AllMembers :members="members_loc" :total="members.total"/>
                <AllSubscriptions :subscriptions="subscriptions"/>
                <ActiveMembers class="mt-4" :percentage="percentage"/>
            </div>
            <div>
                <NewMovements :members="new_members" title="New Members"/>
                <NewMovements class="mt-4" :members="new_cancels" title="Cancellations"/>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import CountryFlag from "vue-country-flag-next";
import NewMovements from "./Components/Overview/NewMovements";
import ActiveMembers from "./Components/Overview/ActiveMembers";
import AllMembers from "./Components/Overview/AllMembers";
import AllSubscriptions from "./Components/Overview/AllSubscriptions";

export default {
    components: {
        AllSubscriptions,
        AllMembers,
        ActiveMembers,
        NewMovements,
        Admin,
        CountryFlag
    },
    props: ['new_members', 'new_cancels', 'percentage', 'members', 'members_loc', 'subscriptions']
}

// RtOHsbo5HIX07vK9ARd52PYTLdO3ciRB
</script>

