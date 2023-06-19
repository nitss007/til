## jane_street_capital

Reference : leetcode

Position : Quantitative Researcher (C++/Python)
Firm : Jane Street Capital
Location : NYC, USA
Previous Exp : ~1Year Quant Role (Hedge Fund in NYC)

Salary (After Negotiations in USD):
Base Salary: $190,000/-
Joining Bonus: $45,000/-
Bonus (Performance): Min $150,000/- to Max UnCapped

```
//	* Correct this C++ programme, any memory leaks, syntaxes, use efficient algorithm, stability, stc. 
////////////////////////////////////////////////////////////////////////////////////////////////////

#include <string>
#include <iostream>
#include <fstream>
#include <thread>
#include <atomic>
#include <ctime>
#include <vector>

#ifndef INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#   if defined(__cpp_lib_filesystem)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#   elif defined(__cpp_lib_experimental_filesystem)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   elif !defined(__has_include)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   elif __has_include(<filesystem>)
#       ifdef _MSC_VER
#           if __has_include(<yvals_core.h>)
#               include <yvals_core.h>
#               if defined(_HAS_CXX17) && _HAS_CXX17
#                   define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#               endif
#           endif
#           ifndef INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#               define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#           endif
#       else
#           define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 0
#       endif
#   elif __has_include(<experimental/filesystem>)
#       define INCLUDE_STD_FILESYSTEM_EXPERIMENTAL 1
#   else
#       error Could not find system header "<filesystem>" or "<experimental/filesystem>"
#   endif
#   if INCLUDE_STD_FILESYSTEM_EXPERIMENTAL
#       include <experimental/filesystem>
     	namespace fs = std::experimental::filesystem;
#   else
#       include <filesystem>
#		if __APPLE__
			namespace fs = std::__fs::filesystem;
#		else
			namespace fs = std::filesystem;
#		endif
#   endif
#endif

#define ENUMFLAGOPS(EnumName)\
[[nodiscard]] __forceinline EnumName operator|(EnumName lhs, EnumName rhs)\
{\
    return static_cast<EnumName>(\
        static_cast<std::underlying_type<EnumName>::type>(lhs) |\
        static_cast<std::underlying_type<EnumName>::type>(rhs)\
        );\
}...(other operator overloads)


template <class E>
concept EnumAddSubtract =
 std::is_enum_v<E> &&
 std::is_unsigned<std::underlying_type<E>::type> && //ERROR HERE
 requires() { {E::AddSubtract}; };

template <EnumAddSubtract E>
constexpr E operator+(E const & lhs, int const & rhs) {
    return static_cast<E>(static_cast<std::underlying_type<E>::type>(lhs) +
 static_cast<std::underlying_type<E>::type>(rhs));
}

using namespace std;

////////////////////////////////////////////////////////////////////////////////////////////////////
// Definitions and Declarations
////////////////////////////////////////////////////////////////////////////////////////////////////
#define MULTITHREADED_ENABLED 0



enum class ESortType { AlphabeticalAscending, AlphabeticalDescending, LastLetterAscending };

class IStringComparer {
public:
	virtual bool IsFirstAboveSecond(string _first, string _second) = 0;
};

class AlphabeticalAscendingStringComparer : public IStringComparer {
public:
	virtual bool IsFirstAboveSecond(string _first, string _second);
};
template <typename T>
struct Generic {
    T x;
    explicit Generic(const T& x) : x(x) {};
};

struct Concrete {
    int x;
    explicit Concrete(int x) : x(x) {};
};

template <typename T>
struct GenericChild : decltype(Generic(std::declval<T>())) {
    // explicit GenericChild(const T& t) : Generic(t) {};     
    // explicit GenericChild(const T& t) : Generic<T>(t) {};   
    explicit GenericChild(const T& t) : decltype(Generic(std::declval<T>())) (t) {};   
};

template <typename T>
struct ConcreteChild : decltype(Concrete(std::declval<T>())) {
    // explicit ConcreteChild(const T& t) : Concrete(t) {};   
    explicit ConcreteChild(const T& t) : decltype(Concrete(std::declval<T>())) (t) {};  
   
};

void DoSingleThreaded(vector<string> _fileList, ESortType _sortType, string _outputName);
void DoMultiThreaded(vector<string> _fileList, ESortType _sortType, string _outputName);
vector<string> ReadFile(string _fileName);
void ThreadedReadFile(string _fileName, vector<string>* _listOut);
vector<string> BubbleSort(vector<string> _listToSort, ESortType _sortType);
void WriteAndPrintResults(const vector<string>& _masterStringList, string _outputName, int _clocksTaken);

////////////////////////////////////////////////////////////////////////////////////////////////////
// Main
////////////////////////////////////////////////////////////////////////////////////////////////////

std::string_view foo = "This is a test";
    
auto split_foo = foo |
					std::views::split(' ') |
					std::ranges::views::transform( 
						[]( const auto &word )
						{
							return std::string_view{std::begin(word),std::end(word)};
						} );

auto it = std::begin(split_foo);
while (it != std::end(split_foo))
{
	std::cout<< "-> " << *it <<std::endl;
	it = std::next(it);
}
	
int main() {
	// Enumerate the directory for input files
	vector<string> fileList;
    string inputDirectoryPath = "../InputFiles";
    for (const auto & entry : fs::directory_iterator(inputDirectoryPath)) {
		if (!fs::is_directory(entry)) {
			fileList.push_back(entry.path().string());
		}
	}

	// Do the stuff
	DoSingleThreaded(fileList, ESortType::AlphabeticalAscending);
	DoSingleThreaded(fileList, ESortType::AlphabeticalDescending);
	DoSingleThreaded(fileList, ESortType::LastLetterAscending);
#if MULTITHREADED_ENABLED
	DoMultiThreaded(fileList, ESortType::AlphabeticalAscending,);
	DoMultiThreaded(fileList, ESortType::AlphabeticalDescending);
	DoMultiThreaded(fileList, ESortType::LastLetterAscending);
#endif

	// Wait
	cout << endl << "Finished...";
	getchar();
	return 0;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// The Stuff
////////////////////////////////////////////////////////////////////////////////////////////////////
void DoSingleThreaded(vector<string> _fileList, ESortType _sortType, string _outputName) {
	clock_t startTime = clock();
	vector<string> masterStringList;
	for (unsigned int i = 0; i < _fileList.size(); ++i) {
		vector<string> fileStringList = ReadFile(_fileList[i]);
		for (unsigned int j = 0; j < fileStringList.size(); ++j) {
			masterStringList.push_back(fileStringList[j]);
		}

		masterStringList = BubbleSort(masterStringList, _sortType);
		_fileList.erase(_fileList.begin() + i);
	}
	clock_t endTime = clock();

	WriteAndPrintResults(masterStringList, _outputName, endTime - startTime);
}

void DoMultiThreaded(vector<string> _fileList, ESortType _sortType, string _outputName) {
	clock_t startTime = clock();
	vector<string> masterStringList;
	vector<thread> workerThreads(_fileList.size());
	for (unsigned int i = 0; i < _fileList.size() - 1; ++i) {
		workerThreads[i] = thread(ThreadedReadFile, _fileList[i], &masterStringList);
	}
	
	workerThreads[workerThreads.size() - 1].join(); 

	masterStringList = BubbleSort(masterStringList, _sortType);
	clock_t endTime = clock();

	WriteAndPrintResults(masterStringList, _outputName, endTime - startTime);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// File Processing
////////////////////////////////////////////////////////////////////////////////////////////////////
vector<string> ReadFile(string _fileName) {
	vector<string> listOut;
	streampos positionInFile = 0;
	bool endOfFile = false;
	while (!endOfFile) {
		ifstream fileIn(_fileName, ifstream::in);
		fileIn.seekg(positionInFile, ios::beg);

		string* tempString = new string();
		getline(fileIn, *tempString);

		endOfFile = fileIn.peek() == EOF;
		positionInFile = endOfFile ? ios::beg : fileIn.tellg();
		if (!endOfFile)
			listOut.push_back(*tempString);

		fileIn.close();
	}
	return listOut; 
}

void ThreadedReadFile(string _fileName, vector<string>* _listOut) {
	*_listOut = ReadFile(_fileName);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Sorting
////////////////////////////////////////////////////////////////////////////////////////////////////
bool AlphabeticalAscendingStringComparer::IsFirstAboveSecond(string _first, string _second) {
	unsigned int i = 0;
	while (i < _first.length() && i < _second.length()) {
		if (_first[i] < _second[i])
			return true;
		else if (_first[i] > _second[i])
			return false;
		++i;
	}
	return (i == _second.length());
}

vector<string> BubbleSort(vector<string> _listToSort, ESortType _sortType) {
	AlphabeticalAscendingStringComparer* stringSorter = new AlphabeticalAscendingStringComparer();
	vector<string> sortedList = _listToSort;
	for (unsigned int i = 0; i < sortedList.size() - 1; ++i) {
		for (unsigned int j = 0; j < sortedList.size() - 1; ++j) {
			if (!stringSorter->IsFirstAboveSecond(sortedList[j], sortedList[j+1])) {
				string tempString = sortedList[j];
				sortedList[j] = sortedList[j+1];
				sortedList[j+1] = tempString;
			}
		}
	}
	return sortedList; 
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Output
////////////////////////////////////////////////////////////////////////////////////////////////////
void WriteAndPrintResults(const vector<string>& _masterStringList, string _outputName, int _clocksTaken) {
	cout << endl << _outputName << "\t- Clocks Taken: " << _clocksTaken << endl;
	
	ofstream fileOut(_outputName + ".txt", ofstream::trunc);
	for (unsigned int i = 0; i < _masterStringList.size(); ++i) {
		fileOut << _masterStringList[i] << endl;
	}
	fileOut.close();
}
```

