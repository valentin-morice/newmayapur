<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">Tools</h1>
        <ExportXLSX :currencies_members="currencies_members"
                    :currencies_payments="currencies_payments"
                    :payment_status="payment_status"
        />
        <AddOffline/>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import AddOffline from "./Components/Tools/AddOffline";
import ExportXLSX from "./Components/Tools/ExportXLSX";

export default {
    components: {
        ExportXLSX,
        AddOffline,
        Admin,
    },
    props: ['currencies_members', 'payment_status', 'currencies_payments'],
}
</script>
