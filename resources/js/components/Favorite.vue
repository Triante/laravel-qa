<template>
    <a :title="isFavorited ? 'Unmark question as favorite' : 'Mark question as favorite'" 
    :class="classes" @click.prevent="toggle">
            <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{count}}</span>
    </a>
</template>

<script>
import favoriteVue from './favorite.vue';
export default {
    props: ['question'],
    data() {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
            id: this.question.id
        }
    },

    methods: {
        toggle() {
            if (!this.signedIn) {
                this.$toast.warning("Please login to favorite question", "Warning", {
                    timeoute: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
            this.isFavorited ? this.destroy() : this.create();
        },
        destroy() {
            axios.delete(this.endpoint)
            .then(res => {
                this.count--;
                this.isFavorited = false;
            });
        },
        create() {
            axios.post(this.endpoint)
            .then(res => {
                this.count++;
                this.isFavorited = true;
            });
        },
    },

    computed: {
        classes() {
            return [
                'favorite', 'mt-2',
                !this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
            ];
        },
        endpoint() {
            return `/questions/${this.id}/favorites`;
        },
    }
}
</script>

