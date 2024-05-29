<template>
<div v-if="show" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-5 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl mb-4">Edit User</h2>
        <form @submit.prevent="updateUser">
            <div class="mb-4">
                <label for="edit-name" class="block text-gray-700">Name:</label>
                <input type="text" id="edit-name" v-model="user.name" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="edit-email" class="block text-gray-700">Email:</label>
                <input type="email" id="edit-email" v-model="user.email" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="edit-password" class="block text-gray-700">Password:</label>
                <input type="password" id="edit-password" v-model="user.password" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Update</button>
        </form>
    </div>
</div>
</template>

<script>
export default {
    props: {
        show: Boolean,
        user: Object
    },
    methods: {
        async updateUser() {
            try {
                const response = await axios.put(`/api/users/${this.user.id}`, this.user);
                this.$emit('user-updated', response.data);
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
