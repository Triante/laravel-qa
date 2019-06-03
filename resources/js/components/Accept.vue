<template>
    <div>
        <a v-if="canAccept" title="Mark this as best answer" :class="classes" @click.prevent="create">
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-if="accepted" title="Accepted as best answer by question owner" :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
export default {
    props: ['answer'],
        data() {
        return {
            isBest: this.answer.is_best,
            id: this.answer.id
        }
    },
    methods: {
        create() {
            axios.post(`/answers/${this.id}/accept`)
            .then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timoeout: 3000,
                    positition: 'bottomLeft'
                });
                this.isBest = true;
            })
            .catch(err => {
                console.log(err);
            })
        }
    },
    computed: {
        canAccept() {
            return this.authorize('accept', this.answer);
        },
        accepted() {
            return !this.canAccept && this.isBest;
        },
        classes() {
            return [
                'mt-2', 'vote-accept',
                this.isBest ? 'vote-accepted' : ''
            ]
        }
    },
}
</script>

