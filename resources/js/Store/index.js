import {createStore} from 'vuex'
import {Inertia} from '@inertiajs/inertia'

export default createStore({
    state() {
        return {
            survey: null,
            activeIndex: 0,
            payload: [],
            anonymous: false,
            successResponse: null
        }
    },
    getters: {
        activeIndex: state => state.activeIndex,

        questions: state => state.survey?.questions || [],

        answered: (state) => state.payload.length,

        successResponse: state => state.successResponse
    },
    mutations: {
        increment: state => state.activeIndex++,

        submitted: (state, payload) => {
            state.payload = [...state.payload, payload];
        },

        setSurvey: (state, survey) => state.survey = survey,

        answerAnonymously: (state) => state.anonymous = true,

        setSuccessResponse: state => state.successResponse = true
    },
    actions: {
        setFormElement: ({getters, commit, dispatch}, payload) => {
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
            if (!state.payload.length) {
                alert('you haven\'t answered any of our questions');
                return
            }

            const anon = state.anonymous ? 'true' : 'false';

            return Inertia.post(route('surveys.sendResponse', [state.survey.id, anon]), state.payload, {
                preserveScroll: () => true,
                onFinish: () => {
                    commit('setSuccessResponse')
                },
                onError: () => toaster('something went wrong and we couldn\'t handle your request.')
            })
        }
    }
})
