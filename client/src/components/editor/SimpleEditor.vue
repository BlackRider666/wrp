<template>
  <div class="py-4 simpleEditor-container">
    <div ref="simpleEditor"></div>
  </div>
</template>

<script>
import Quill from 'quill';
import "quill/dist/quill.core.css";
import "quill/dist/quill.bubble.css";
import "quill/dist/quill.snow.css";

export default {
  name: 'SimpleEditor',
  props: {
    value: {
      type:String,
      default:'',
    },
    placeholder: {
      type:String,
      default:'Type something in here!'
    }
  },
  data() {
    return {
      quill: null,
    };
  },
  mounted() {
    let _this = this;
    this.quill = new Quill(this.$refs.simpleEditor, {
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline'],
          ['clean']
        ],
        history: {
          delay: 2000,
          maxStack: 500,
          userOnly: true
        }
      },
      theme: "snow",
      formats: ["bold", "underline", "italic"],
      placeholder: this.placeholder,
    });
    this.quill.root.innerHTML = this.value;
    this.quill.on("text-change", function () {
      return _this.update();
    });
  },
  methods: {
    update: function update() {
      this.$emit(
          "input",
          this.quill.getText() ? this.quill.root.innerHTML : ""
      );
    },
  },
}
</script>

<style>
.simpleEditor-container .ql-container{
  cursor: text;
  border-top: 1px;
  border-color: #9e9e9e;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
}
.simpleEditor-container .ql-container .ql-blank {
  min-height: 200px;
}
.simpleEditor-container:hover .ql-container {
  border-color: rgba(0,0,0,0.87);
}
.simpleEditor-container:hover .ql-toolbar.ql-snow{
  border-color: rgba(0,0,0,0.87);

}
</style>
