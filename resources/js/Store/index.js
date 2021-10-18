import {createStore} from 'vuex'
import { Inertia } from '@inertiajs/inertia'
import dispatch from "alpinejs";

export default createStore({
    state() {
        return {
            survey: null,
            activeIndex: 0,
            payload: []
        }
    },
    getters: {
        activeIndex: state => state.activeIndex,

        questions: state => state.survey?.questions || []
    },
    mutations: {
        increment: state => state.activeIndex++,

        submitted: (state, payload) => {
            state.payload = [...state.payload, payload];
        },

        setSurvey: (state, survey) => state.survey = survey
    },
    actions: {
        setFormElement: ({ getters, commit, dispatch}, payload) => {
            commit('submitted', payload)

            if (getters.activeIndex + 1 === getters.questions.length) {
                dispatch('submitForm').then((response) => {
                    console.log(response)
                })
            } else {
                commit('increment')
            }
        },

        submitForm: ({state, commit}) => {
            if (! state.payload.length) {
                alert('you haven\'t answered any of our questions');
                return
            }

            return Inertia.post(route('surveys.sendResponse', state.survey.id), state.payload, {
                preserveScroll: () => true,
                onFinish: () => alert('thank you for your time!'),
                onError: () => alert('something went wrong and we couldn\'t handle your request.')
            })
        }
    }
})
