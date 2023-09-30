import {Head, useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import Guest from "@/Layouts/GuestLayout.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {Transition} from "@headlessui/react";
import {convertDate} from "@/helpers/converDate.js";

export default  function Publication ({auth, posts, comments}) {
    console.log(comments);
    const {title, description, author, id}  = posts;
    const {errors, processing, recentlySuccessful, data, post, setData} = useForm({
        name: "",
        comment: ""
    });
    const submit = (e) => {
        e.preventDefault();
        post(`/create-comment/${id}`);
    }

    return (
        <Guest
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Publication Page</h2>}
        >
            <Head title="Publication Page" />

            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 className="p-6 text-lg font-medium text-gray-900">
                        {title}
                    </h2>
                    <div className="p-6 text-gray-900">{description}</div>
                    <div className="p-6 flex items-center gap-4">
                        <p className="mt-1 text-sm text-gray-600">
                            Author: {author}
                        </p>
                    </div>
                </div>


                <form onSubmit={submit} className="mt-6 space-y-6">
                    <div>
                        <InputLabel htmlFor="name" value="Name" />

                        <TextInput
                            id="name"
                            className="mt-1 block w-full"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                            isFocused
                            autoComplete="name"
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div>
                        <InputLabel htmlFor="description" value="Comment" />

                        <TextInput
                            id="comment"
                            className="mt-1 block w-full"
                            value={data.comment}
                            onChange={(e) => setData('comment', e.target.value)}
                            required
                            autoComplete="comment"
                        />

                        <InputError className="mt-2" message={errors.comment} />
                    </div>


                    <div className="flex items-center gap-4">
                        <PrimaryButton disabled={processing}>Post Comment</PrimaryButton>

                        <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
            <div>
                {comments.map((comment) => (
                    <div className="mb-5 border-2 shadow-inner  hover:shadow-lg  flex flex-col text-center">
                        <a href="#">{comment.name}</a>
                        <div>{convertDate(comment.created_at)}</div>
                        <div>{comment.comment}</div>
                    </div>
                ))}
            </div>
        </Guest>
    )
}
