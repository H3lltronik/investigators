import { createStore } from 'vuex'

export const store = createStore({
    state() {
        return {
            requestForm: {
                addresses: [
                    {
                        name: '1',
                        city: '2',
                        address: '3',
                        phone: '4',
                        hasExtendedQuestions: true,
                        
                    },
                ],
            }
        }
    },
    mutations: {
        updateRequestForm(state, payload) {
            state.requestForm = payload;
        }
    },
    getters: {
        requestForm(state) {
            return state.requestForm
        },
        extendedQuestionsQnt (state) {
            return state.requestForm.addresses.reduce((acc, item) => {
                let total = acc;
                if (item.hasExtendedQuestions)
                    total += item.extendedQuestions.length;

                return total;
            }, 0)
        }
    },
})