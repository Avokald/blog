const helper = {
   absoluteToRelativePath(path) {
       return path.replace(/^(?:\/\/|[^/]+)*\//, '');
   }


};


export default helper;