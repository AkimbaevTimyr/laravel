
export function convertDate(date){
    const newDate = new Date(date);

    return newDate.toISOString().replace(/T/, ' ').replace(/\..+/, '');
}
