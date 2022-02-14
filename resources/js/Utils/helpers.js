import { ElNotification } from 'element-plus';

export const showNotification = function (type, title, message) {
    ElNotification({ title, message, type, duration: 6000 });
}