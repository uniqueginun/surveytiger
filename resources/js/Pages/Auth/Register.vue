<template>
    <Head title="Register"/>

    <jet-authentication-card>
        <template #logo>
            <jet-application-mark width="60"/>
        </template>

        <div class="card-body">

            <jet-validation-errors class="mb-3"/>

            <form @submit.prevent="submit">
                <div class="mb-3">
                    <jet-label for="name" value="Name"/>
                    <jet-input id="name" v-model="form.name" autocomplete="name" autofocus required type="text"/>
                </div>

                <div class="mb-3">
                    <jet-label for="email" value="Email"/>
                    <jet-input id="email" v-model="form.email" required type="email"/>
                </div>

                <div class="mb-3">
                    <jet-label for="password" value="Password"/>
                    <jet-input id="password" v-model="form.password" autocomplete="new-password" required
                               type="password"/>
                </div>

                <div class="mb-3">
                    <jet-label for="password_confirmation" value="Confirm Password"/>
                    <jet-input id="password_confirmation" v-model="form.password_confirmation" autocomplete="new-password" required
                               type="password"/>
                </div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <jet-checkbox id="terms" v-model:checked="form.terms" name="terms"/>

                        <label class="custom-control-label" for="terms">
                            I agree to the <a :href="route('terms.show')" target="_blank">Terms of Service</a> and <a
                            :href="route('policy.show')" target="_blank">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <Link :href="route('login')" class="text-muted mr-3 text-decoration-none">
                            Already registered?
                        </Link>

                        <jet-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing"
                                    class="ms-4">
                            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            Register
                        </jet-button>
                    </div>
                </div>
            </form>
        </div>
    </jet-authentication-card>
</template>

<script>
import {defineComponent} from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetApplicationMark,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
})
</script>
