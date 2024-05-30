<template>
<div>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Reset Password </h1>
            <form @submit.prevent="resetPassword">
                <input type="hidden" v-model="token">
                <!-- <div>
                <label for="email">Email</label>
                <input type="email" id="email" v-model="email" required>
            </div>
            <div>
                <label for="password">New Password</label>
                <input type="password" id="password" v-model="password" required>
            </div>
            <div>
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" v-model="password_confirmation" required>
            </div> -->
                <div class="mb-4">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" type="text" v-model="email" required />
                </div>
                <div class="mb-4">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                        New Password
                    </label>
                    <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password" type="password" v-model="password" required />
                </div>
                <div class="mb-4">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password_confirmation">
                        Confirm New Password
                    </label>
                    <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password_confirmation" type="password" v-model="password_confirmation" required />
                </div>
                <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                    type="submit"
                >
                Reset Password
                </button>
                </div>
            </form>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            token: this.$route.query.token,
            email: '',
            password: '',
            password_confirmation: ''
        }
    },
    methods: {
        async resetPassword() {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        token: this.token,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to reset password');
                }

                const data = await response.json();
                alert(data.message);
                this.$router.push('/');
            } catch (error) {
                alert('An error occurred: ' + error.message);
            }
        }
    }
}
</script>
