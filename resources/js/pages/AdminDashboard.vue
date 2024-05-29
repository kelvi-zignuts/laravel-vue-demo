<template>
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl">Admin Dashboard </h1>
            <span class="capitalize">Welcome {{ user && user.name }}, <button
                class="text-orange-500 underline hover:no-underline rounded-md"
                @click="handleLogout">Logout</button></span>
        </div>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import { request } from '../helper'
import Loader from '../components/Loader.vue';

export default {
    components: {
        Loader,
    },
    setup() {
        const user = ref(null);
        const isLoading = ref(false);

        let router = useRouter();
        onMounted(() => {
            authentication();
        });

        const authentication = async () => {
            isLoading.value = true;
            try {
                const req = await request('get', '/api/user');
                user.value = req.data;
            } catch (e) {
                await router.push('/');
            }
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN');
            router.push('/');
        }

        return {
            user,
            isLoading,
            handleLogout,
        }
    },
}
</script>