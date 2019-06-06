import Prism from 'prismjs';

export default {
    methods: {
        highlight() {
            if (this.$refs.bodyHtml) {
                Prism.highlightAllUnder(this.$refs.bodyHtml);
            }
        }
    },
    mounted () {
        this.highlight()
    }
}