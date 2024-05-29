<template>
<div class="w-6/12 p-10 mx-auto">
    <div class="flex justify-between">
        <h1 class="text-2xl">Admin Dashboard</h1>
        <span class="capitalize">Welcome {{ user && user.name }},
            <button class="text-orange-500 underline hover:no-underline rounded-md" @click="handleLogout">Logout</button>
        </span>
    </div>
    <div class="mt-6">
        <button @click="openModal" class="px-4 py-2 bg-green-500 text-white rounded">Create New User</button>
    </div>
    <div v-if="isLoading" class="mt-4">
        <Loader />
    </div>
    <div v-else class="mt-4">
        <h2 class="text-xl mb-4">User List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.email }}</td>
                    <td class="px-4 py-2">
                        <button @click="openEditModal(user)" class="text-blue-500 underline hover:no-underline">Edit</button>
                        <!-- <button @click="deleteUser(user.id)" class="text-red-500 underline hover:no-underline">Delete</button> -->
                        <button @click="deleteUser(user)" class="text-red-500 underline hover:no-underline">Delete</button>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <UserFormModal :show="isModalOpen" @onClose="closeModal" @user-created="handleUserCreated" />
    <UserEditModal :show="isEditModalOpen" :user="editedUser" @user-updated="handleUserUpdated" />
</div>
</template>

<script>
import {
    ref,
    onMounted
} from 'vue';
import {
    useRouter
} from 'vue-router';
import {
    request
} from '../helper';
import Loader from '../components/Loader.vue';
import UserFormModal from '../components/UserFormModal.vue';
import UserEditModal from '../components/UserEditModal.vue';

export default {
    components: {
        Loader,
        UserFormModal,
        UserEditModal
    },
    setup() {
        const user = ref(null);
        const isLoading = ref(false);
        const isModalOpen = ref(false);
        const isEditModalOpen = ref(false);
        const editedUser = ref(null);
        const users = ref([]);

        const router = useRouter();

        onMounted(() => {
            authentication();
            fetchUsers();
        });

        const authentication = async () => {
            isLoading.value = true;
            try {
                const req = await request('get', '/api/user');
                user.value = req.data;
                isLoading.value = false;
            } catch (e) {
                await router.push('/');
            }
        };

        const fetchUsers = async () => {
            try {
                const req = await request('get', '/api/users');
                users.value = req.data;
            } catch (e) {
                console.error(e);
            }
        };

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN');
            router.push('/');
        };

        const openModal = () => {
            isModalOpen.value = true;
        };

        const closeModal = () => {
            isModalOpen.value = false;
            isEditModalOpen.value = false;
        };

        const openEditModal = (user) => {
            editedUser.value = {
                ...user
            }; // Clone the user object
            isEditModalOpen.value = true;
        };

        const handleUserCreated = () => {
            fetchUsers();
            closeModal();
        };

        const handleUserUpdated = (updatedUser) => {
            const index = users.value.findIndex(user => user.id === updatedUser.id);
            if (index !== -1) {
                users.value.splice(index, 1, updatedUser);
            }
            closeModal(); // Close edit modal
        };
        const confirmDelete = (user) => {
            if (window.confirm(`Are you sure you want to delete ${user.name}?`)) {
                deleteUser(user);
            }
        };
        //         const deleteUser = async (userId) => {
        //     try {
        //         await request('delete', `/api/users/${userId}`);
        //         fetchUsers(); // Update user list after deletion
        //     } catch (error) {
        //         console.error('Error deleting user:', error);
        //     }
        // };
        const deleteUser = (user) => {
            const confirmDelete = window.confirm(`Are you sure you want to delete ${user.name}?`);
            if (confirmDelete) {
                performDelete(user.id);
            }
        };

        const performDelete = async (userId) => {
            try {
                await request('delete', `/api/users/${userId}`);
                fetchUsers(); // Update user list after deletion
            } catch (error) {
                console.error('Error deleting user:', error);
            }
        };

        return {
            user,
            isLoading,
            isModalOpen,
            isEditModalOpen,
            editedUser,
            users,
            handleLogout,
            openModal,
            closeModal,
            openEditModal,
            fetchUsers,
            handleUserCreated,
            handleUserUpdated,
            deleteUser
        };
    }
};
</script>
