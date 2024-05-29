<template>
<div v-if="show" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-5 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl mb-4">Create New User</h2>
        <form @submit.prevent="handleSubmit">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" v-model="form.name" class="w-full p-2 border border-gray-300 rounded" required>
                <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" v-model="form.email" class="w-full p-2 border border-gray-300 rounded" required>
                <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="password" v-model="form.password" class="w-full p-2 border border-gray-300 rounded" required>
                <p v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</p>
            </div>
            <div class="flex justify-end">
                <button type="button" @click="closeModal" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Create</button>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import {
    ref
} from 'vue';
import {
    request
} from '../helper';

export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        onClose: {
            type: Function,
            required: true
        }
    },
    setup(props, {
        emit
    }) {
        const form = ref({
            name: '',
            email: '',
            password: ''
        });

        const errors = ref({});

        const closeModal = () => {
            props.onClose();
        };

        const handleSubmit = async () => {
            errors.value = {};
            try {
                await request('post', '/api/users', form.value);
                emit('user-created');
                closeModal();
            } catch (e) {
                if (e.response && e.response.status === 422) {
                    errors.value = e.response.data.errors;
                } else {
                    console.error(e);
                }
            }
        };

        return {
            form,
            errors,
            closeModal,
            handleSubmit
        };
    }
};
</script>
