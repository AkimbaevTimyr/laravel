import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import {useForm} from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useRef} from "react";
import InputError from "@/Components/InputError.jsx";

export default function CreatePostForm({className = ""}){
    const authorInput = useRef();
    const titleInput = useRef();
    const descriptionInput = useRef();

    const { data, setData, processing, errors, post, reset} = useForm({
        title: "",
        description: "",
        file: null
    })

    const submit = (e) => {
        e.preventDefault();
        post(route('post.store', {
            onSuccess: () => reset('title', 'description'),
            onError: (errors) => {
                if (errors.title) {
                    reset('title', 'title');
                    titleInput.current.focus();
                }
                if(error.description) {
                    reset('description', 'description');
                    descriptionInput.current.focus();
                }
            },
        }))
    }

    return (
        <section className={`space-y-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Create post</h2>
                <p className="mt-1 text-sm text-gray-600">
                    You have create post with title and description
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6" encType="multipart/form-data">
                <div>
                    <InputLabel htmlFor="title" value="Title" />

                    <TextInput
                        id="title"
                        ref={titleInput}
                        className="mt-1 block w-full"
                        value={data.title}
                        onChange={(e)=> setData('title', e.target.value)}
                        required
                        isFocused
                        autoComplete="title"
                    />

                    <InputError message={errors.title} className="mt-2" />

                </div>

                <div>
                    <InputLabel htmlFor="description" value="Description" />

                    <TextInput
                        id="description"
                        ref={descriptionInput}
                        className="mt-1 block w-full"
                        value={data.description}
                        onChange={(e)=> setData('description', e.target.value)}
                        required
                        isFocused
                        autoComplete="description"
                    />

                    <InputError message={errors.description} className="mt-2" />

                </div>

                <input type="file" onChange={(e) => setData('file', e.target.files[0])} />

                <InputError message={errors.file} className="mt-2" />

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Create</PrimaryButton>
                </div>
            </form>
        </section>
    )
}
