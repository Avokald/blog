export function absoluteToRelativePath(path) {
       return path.replace(/^(?:\/\/|[^/]+)*\//, '');
}
