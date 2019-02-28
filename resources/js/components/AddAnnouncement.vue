<script>
  export default {
    data(){
      return {
        project: { title: '', description: ''},
        feedback: ''
      }
    },

    methods: {
      addAnnouncement() {

        //console.log(this.project);
        axios.post('/projects', {'title': this.project.title, 'description': this.project.description})
        .then(() => location.reload() )
        .catch(error => this.feedback = error.response.data);
      }
    }
  }
</script>
