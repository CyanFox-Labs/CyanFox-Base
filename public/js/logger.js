Livewire.on('logger', (data) => {
    for (let i = 0; i < data.length; i++) {
        const { type, message } = data[i]

        switch (type) {
            case 'info':
                console.info(message);
                break;
            case 'warn':
                console.warn(message);
                break;
            case 'error':
                console.error(message);
                break;
            default:
                console.log(message);
        }
    }
});
