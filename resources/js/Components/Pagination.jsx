



export default function Pagination({ links }) {
    
    function getClassName(active)
    {
        if(active) {
            return 'flex items-center justify-center px-4 h-10 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white';
        } else {
            return 'flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white';
        }
    }

    
    return (
        <nav aria-label="Page navigation example ">
            <ul className="inline-flex -space-x-px text-base h-10 mt-10">
                {
                    links.map((link) => (
                        <li key={link.label}>
                            <a href={link.url} className={getClassName(link.active)}>
                                { link.label.replace('&laquo;', '<').replace('&raquo;', '>') }
                            </a>
                        </li>
                    ))
                }
            </ul>
        </nav>
    )
}


