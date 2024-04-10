<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- React -->
        <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
        <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6">
                    <main class="p-6 bg-slate-800 bg-opacity-75 rounded-xl">
                        <div id="root"><i>Loading...</i></div>
                        <script type="text/babel">
                            const MyApp = () => {
                                // Load countries on init
                                const [countries, setCountries] = React.useState([]);
                                React.useEffect(() => {
                                    fetch('/countries')
                                        .then((response) => response.json())
                                        .then((data) => {
                                            setCountries(data);
                                        })
                                        .catch((e) => {
                                            console.error(e.message);
                                            alert(e.message);
                                        });
                                }, []);

                                // Keep track of selected Countries and user Search
                                const [selectedCodes, setSelectedCodes] = React.useState([]);
                                const handleCheckboxChange = (code) => {
                                    if (selectedCodes.includes(code)) {
                                        selectedCodes.splice(selectedCodes.indexOf(code), 1);
                                    } else {
                                        selectedCodes.push(code);
                                    }
                                    setSelectedCodes(selectedCodes);
                                }

                                const [search, setSearch] = React.useState();

                                return <table className="w-full">
                                    <tbody>
                                    <tr>
                                        <td className="pb-4">
                                            <SearchBox onChange={setSearch}/>
                                        </td>
                                        <td className="pb-4">
                                            <ShowSelectedButton selectedCodes={selectedCodes} />
                                        </td>
                                    </tr>
                                    <CountryCheckboxList
                                        countries={countries}
                                        selectedCodes={selectedCodes}
                                        handleCheckboxChange={handleCheckboxChange}
                                        search={search}
                                    />
                                    </tbody>
                                </table>
                            }

                            const Checkbox = ({ label, defaultChecked, onChange }) => {
                                return (
                                    <label>
                                        <input
                                            type="checkbox"
                                            className="mr-1"
                                            defaultChecked={defaultChecked}
                                            onChange={onChange}
                                        />
                                        {label}
                                    </label>
                                )
                            }

                            const CountryCheckboxList = ({ countries, selectedCodes, handleCheckboxChange, search }) => {
                                return (countries
                                        .filter((country) => !search
                                            || country.name.toLowerCase().includes(search.toLowerCase())
                                            || country.code.toLowerCase().includes(search.toLowerCase())
                                        )
                                        .map((country) => (
                                            <tr key={country.code} >
                                                <td>{country.name}</td>
                                                <td>
                                                    <Checkbox
                                                        key={country.code}
                                                        label={country.code}
                                                        defaultChecked={selectedCodes.includes(country.code)}
                                                        onChange={() => handleCheckboxChange(country.code)}
                                                    />
                                                </td>
                                            </tr>
                                        ))
                                )
                            }

                            const SearchBox = ({onChange}) => {
                                return <input
                                    placeholder="Search"
                                    className="border-2 px-2 py-1 rounded-md text-black"
                                    onChange={(e) => onChange(e.target.value)}
                                />
                            }

                            const ShowSelectedButton = ({selectedCodes}) => {
                                const [title, setTitle] = React.useState('Show Selected');

                                const handleOnClick = () => {
                                    // todo instead of setting title & alert, show a modal
                                    selectedCodes.length
                                        ? setTitle('Show Selected (' + selectedCodes.join(',') + ')')
                                        : setTitle('Show Selected');
                                    alert(selectedCodes.join(','));
                                }

                                return <button
                                    className="border-2 px-2 py-1 rounded-md"
                                    onClick={handleOnClick}
                                >
                                    { title }
                                </button>
                            }

                            const container = document.getElementById('root');
                            const root = ReactDOM.createRoot(container);
                            root.render(<MyApp />);

                        </script>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
