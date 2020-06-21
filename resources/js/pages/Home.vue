<template>
    <div>

        <input type="text" v-model="post"/>
        <button @click="savedata(post)">Save</button>

        <div v-for="(data, index) in datafromapi" :key="index">
            <h2 v-for="dataUser in data.users_info">
                Posted By: {{dataUser.name}}
            </h2>
            <button @click="deleteThis(data.postId)">Delete This</button>
            <label v-for="dataPost in data.posts">
                {{ dataPost.posts }}
            </label>
            <p v-for="dataComments in data.get_comments">
                {{ dataComments.comments }}
            </p>
            <textarea
                :value="value"
                @blur="updateValue($event.target.value, data.postId)"
                ref="input"
            ></textarea>
            <button @click="savethiscomment">Save Comment</button>
        </div>

    </div>
</template>
<script>
export default {
    data: function(){
        return {
            post:                       '',
            value:                      '',
            datafromapi:                [],
            dataToPass:                 [],
        }
    },
    created: function(){
        this.getPosts();
    },
    methods: {
        getPosts(){
            let url = '/api/getPosts';
            axios.get(url)
            .then((response) => {
                if(response.data.haspassed){
                    this.datafromapi = [];
                    this.datafromapi = response.data.output;
                }
            });
        },
        savedata(data){
            let url = '/api/insertPosts';
            axios.post(url, {posts: data})
            .then((response) => {
                if(response.data.haspassed){
                    this.getPosts();
                }
            });
        },
        deleteThis(data){
            let url = '/api/deletethis';
            axios.post(url, {id: data})
            .then((response) => {
                if(response.data.haspassed){
                    this.getPosts();
                }
            });
        },
        updateValue(value, id){
            let test = this.$refs.input.value = value;
            this.dataToPass.push({
                'comment':          test,
                'id':               id
            });
        },
        savethiscomment(){
            // console.log(this.dataToPass);
            let url = '/api/addcomment';
            axios.post(url, this.dataToPass)
            .then((response) => {
                // console.log(response.data);
                if(response.data.haspassed){
                    this.dataToPass = [];
                    this.getPosts();
                }
            });
        }
    }
}
</script>